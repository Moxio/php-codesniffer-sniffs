<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowMbDetectEncodingSniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['mb_detect_encoding'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $error = 'Using mb_detect_encoding() is not allowed; use mb_check_encoding() instead';
        $phpcsFile->addError($error, $functionNamePtr, 'Disallowed');
    }
}
