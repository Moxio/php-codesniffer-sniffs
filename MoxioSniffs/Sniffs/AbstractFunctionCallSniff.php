<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_Codesniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\ReferencedNameHelper;

abstract class AbstractFunctionCallSniff implements Sniff
{
    public $supportedTokenizers = array(
        'PHP',
    );

    protected $skipForUnpackedArguments = false;

    public function register()
    {
        return array(T_STRING);
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionNamePtr    = $stackPtr;
        $functionName = $tokens[$functionNamePtr]['content'];

        // If the next non-whitespace token after the function or method call
        // is not an opening parenthesis then it cant really be a *call*.
        $openBracket = $phpcsFile->findNext(Tokens::$emptyTokens, ($functionNamePtr + 1), null, true);
        if ($tokens[$openBracket]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }

        // Skip tokens that are instance *method* calls rather than static calls
        $callOperator = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($functionNamePtr - 1), null, true);
        if ($tokens[$callOperator]['code'] === T_OBJECT_OPERATOR) {
            return;
        }

		// If this is a static method call, prefix function name with class
		if ($tokens[$callOperator]['code'] === T_DOUBLE_COLON) {
			$beforeNameStartPtr = $phpcsFile->findPrevious(array_merge(
				array(T_STRING, T_NS_SEPARATOR),
				Tokens::$emptyTokens
			), $callOperator - 1, null, true);
			// Skip static method calls invoked in non-static way (not directly on static class name)
			if ($beforeNameStartPtr === false) {
				return;
			}
			$nameStartPtr = $phpcsFile->findNext(array(T_STRING, T_NS_SEPARATOR), $beforeNameStartPtr + 1);
			$nameEndPtr = ReferencedNameHelper::getReferencedNameEndPointer($phpcsFile, $nameStartPtr);
			$name = ReferencedNameHelper::getReferenceName($phpcsFile, $nameStartPtr, $nameEndPtr);
			$fqName = NamespaceHelper::resolveClassName($phpcsFile, $name, $nameStartPtr);
			$functionName = $fqName . '::' . $functionName;
		}

		$registeredFunctions = $this->registerFunctions();
		if (in_array($functionName, $registeredFunctions, true) !== true) {
			// We're not interested in calls to *this* function
			return;
		}

        // Skip tokens that are the names of functions or classes
        // within their definitions. For example:
        // function myFunction...
        // "myFunction" is T_STRING but we should skip because it is not a
        // function or method *call*.
        $ignoreTokens    = Tokens::$emptyTokens;
        $ignoreTokens[]  = T_BITWISE_AND;
        $functionKeyword = $phpcsFile->findPrevious($ignoreTokens, ($stackPtr - 1), null, true);
        if ($tokens[$functionKeyword]['code'] === T_FUNCTION || $tokens[$functionKeyword]['code'] === T_CLASS) {
            return;
        }

        $closeBracket = $tokens[$openBracket]['parenthesis_closer'];

        $argumentPositions = array();
        $hasUnpackedArgument = false;
        $lastArgumentSeparator = $openBracket;
        $nextSeparator = $openBracket;
        while (($nextSeparator = $phpcsFile->findNext(array(T_COMMA, T_OPEN_SHORT_ARRAY), ($nextSeparator + 1), $closeBracket)) !== false) {
            // Skip over pairs of square brackets
            if ($tokens[$nextSeparator]['code'] === T_OPEN_SHORT_ARRAY) {
                $nextSeparator = $tokens[$nextSeparator]['bracket_closer'];
                continue;
            }

            // Make sure the comma or variable belongs directly to this function call,
            // and is not inside a nested function call or array.
            $brackets    = $tokens[$nextSeparator]['nested_parenthesis'];
            $lastBracket = array_pop($brackets);
            if ($lastBracket !== $closeBracket) {
                continue;
            }

            $argumentStart = $phpcsFile->findNext(Tokens::$emptyTokens, $lastArgumentSeparator + 1, $nextSeparator, true);
            if ($argumentStart !== false) {
                $argumentEnd = $phpcsFile->findPrevious(Tokens::$emptyTokens, $nextSeparator - 1, $lastArgumentSeparator, true);
                $argumentPositions[] = array(
                    "start" => $argumentStart,
                    "end" => $argumentEnd
                );
            }

            $lastArgumentSeparator = $nextSeparator;
        }

        // Add the final argument, if any
        $argumentStart = $phpcsFile->findNext(Tokens::$emptyTokens, $lastArgumentSeparator + 1, $closeBracket, true);
        if ($argumentStart !== false) {
            $argumentEnd = $phpcsFile->findPrevious(Tokens::$emptyTokens, $closeBracket - 1, $lastArgumentSeparator, true);

            $ellipsis = $phpcsFile->findNext(T_ELLIPSIS, $argumentStart, $argumentEnd);
            if ($ellipsis !== false) {
                $brackets = $tokens[$ellipsis]['nested_parenthesis'];
                $lastBracket = array_pop($brackets);
                if ($lastBracket === $closeBracket) {
                    $hasUnpackedArgument = true;
                }
            }

            $argumentPositions[] = array(
                "start" => $argumentStart,
                "end" => $argumentEnd
            );
        }

        if ($this->skipForUnpackedArguments && $hasUnpackedArgument) {
            return;
        }

        $this->processFunctionCall($phpcsFile, $functionName, $functionNamePtr, $argumentPositions);
    }

    /**
     * Should return the names of the functions of which calls should be processed by this sniff.
     */
    abstract protected function registerFunctions();

    /**
     * Called whenever a call to one of the functions from `registerFunctions` is encountered.
     */
    abstract protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs);
}
