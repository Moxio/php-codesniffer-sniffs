<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\ReferencedNameHelper;

class DisallowDateTimeSniff implements Sniff
{
    public $supportedTokenizers = array(
        'PHP',
    );

    public function register()
    {
        return array(T_NEW, T_DOUBLE_COLON);
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === T_NEW) {
            $nameStartPtr = $phpcsFile->findNext(array(T_STRING, T_NS_SEPARATOR), $stackPtr + 1);
            $nameEndPtr = ReferencedNameHelper::getReferencedNameEndPointer($phpcsFile, $nameStartPtr);
            $variantCode = 'New';
        } elseif ($tokens[$stackPtr]['code'] === T_DOUBLE_COLON) {
            $beforeNameStartPtr = $phpcsFile->findPrevious(array_merge(
                array(T_STRING, T_NS_SEPARATOR),
                Tokens::$emptyTokens
            ), $stackPtr - 1, null, true);
            $nameStartPtr = $phpcsFile->findNext(array(T_STRING, T_NS_SEPARATOR), $beforeNameStartPtr + 1);
            $nameEndPtr = ReferencedNameHelper::getReferencedNameEndPointer($phpcsFile, $nameStartPtr);
            $variantCode = 'StaticMethod';

            $memberNamePtr = $phpcsFile->findNext(array(T_STRING), $stackPtr + 1);
            if ($tokens[$memberNamePtr]['content'] === 'class') {
                // Ignore references to 'harmless' ::class pseudo-constant
                return;
            }
        } else {
            throw new \LogicException(sprintf("Unexpected token type '%s'", $tokens[$stackPtr]['code']));
        }

        $name = ReferencedNameHelper::getReferenceName($phpcsFile, $nameStartPtr, $nameEndPtr);
        $fqName = NamespaceHelper::resolveClassName($phpcsFile, $name, $nameStartPtr);
        if ($fqName === '\DateTime') {
            $error = 'Use DateTimeImmutable instead of DateTime';
            $phpcsFile->addError($error, $nameStartPtr, $variantCode);
        }
    }
}
