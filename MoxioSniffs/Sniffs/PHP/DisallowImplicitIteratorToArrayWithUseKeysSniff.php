<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowImplicitIteratorToArrayWithUseKeysSniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['iterator_to_array'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        if (count($argumentPtrs) < 2) {
            $error = 'The $use_keys-parameter to iterator_to_array must be explicitly set';
            $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotGiven');
        }
    }
}
