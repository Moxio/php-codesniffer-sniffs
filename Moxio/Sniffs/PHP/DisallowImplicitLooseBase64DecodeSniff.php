<?php
namespace Moxio\Sniffs\PHP;

use Moxio\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowImplicitLooseBase64DecodeSniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['base64_decode'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        if (count($argumentPtrs) < 2) {
            $error = 'The $strict-parameter to base64_decode must be explicitly set';
            $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotGiven');
        }
    }
}
