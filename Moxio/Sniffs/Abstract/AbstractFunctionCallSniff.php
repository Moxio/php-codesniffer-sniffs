<?php
abstract class Moxio_Sniffs_Abstract_AbstractFunctionCallSniff implements PHP_CodeSniffer_Sniff
{
    public $supportedTokenizers = array(
        'PHP',
    );

    public function register()
    {
        return array(T_STRING);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionNamePtr    = $stackPtr;
        $functionName = $tokens[$functionNamePtr]['content'];

        $registeredFunctions = $this->registerFunctions();
        if (in_array($functionName, $registeredFunctions, true) !== true) {
            // We're not interested in calls to *this* function
            return;
        }

        // If the next non-whitespace token after the function or method call
        // is not an opening parenthesis then it cant really be a *call*.
        $openBracket = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, ($functionNamePtr + 1), null, true);
        if ($tokens[$openBracket]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }

        // Skip tokens that are *method* calls rather than *function* calls
        $callOperator = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($functionNamePtr - 1), null, true);
        if ($tokens[$callOperator]['code'] === T_OBJECT_OPERATOR || $tokens[$callOperator]['code'] === T_DOUBLE_COLON) {
            return;
        }

        // Skip tokens that are the names of functions or classes
        // within their definitions. For example:
        // function myFunction...
        // "myFunction" is T_STRING but we should skip because it is not a
        // function or method *call*.
        $ignoreTokens    = PHP_CodeSniffer_Tokens::$emptyTokens;
        $ignoreTokens[]  = T_BITWISE_AND;
        $functionKeyword = $phpcsFile->findPrevious($ignoreTokens, ($stackPtr - 1), null, true);
        if ($tokens[$functionKeyword]['code'] === T_FUNCTION || $tokens[$functionKeyword]['code'] === T_CLASS) {
            return;
        }

        $closeBracket = $tokens[$openBracket]['parenthesis_closer'];

        $argumentPositions = array();
        $lastArgumentSeparator = $openBracket;
        $nextSeparator = $openBracket;
        while (($nextSeparator = $phpcsFile->findNext(array(T_COMMA), ($nextSeparator + 1), $closeBracket)) !== false) {
            // Make sure the comma or variable belongs directly to this function call,
            // and is not inside a nested function call or array.
            $brackets    = $tokens[$nextSeparator]['nested_parenthesis'];
            $lastBracket = array_pop($brackets);
            if ($lastBracket !== $closeBracket) {
                continue;
            }

            $argumentStart = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $lastArgumentSeparator + 1, $nextSeparator, true);
            if ($argumentStart !== false) {
                $argumentEnd = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, $nextSeparator - 1, $lastArgumentSeparator, true);
                $argumentPositions[] = array(
                    "start" => $argumentStart,
                    "end" => $argumentEnd
                );
            }

            $lastArgumentSeparator = $nextSeparator;
        }

        // Add the final argument, if any
        $argumentStart = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $lastArgumentSeparator + 1, $closeBracket, true);
        if ($argumentStart !== false) {
            $argumentEnd = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, $closeBracket - 1, $lastArgumentSeparator, true);
            $argumentPositions[] = array(
                "start" => $argumentStart,
                "end" => $argumentEnd
            );
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
    abstract protected function processFunctionCall(PHP_CodeSniffer_File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs);
}
