<?php
namespace Moxio\Sniffs\PHP;

use Moxio\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowImplicitMicrotimeAsStringSniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['microtime'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        if (count($argumentPtrs) < 1) {
            $error = 'The $get_as_float-parameter to microtime must be explicitly set';
            $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotGiven');
        }
    }
}
