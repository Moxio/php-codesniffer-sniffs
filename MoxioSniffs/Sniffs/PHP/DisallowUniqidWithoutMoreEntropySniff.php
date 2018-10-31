<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowUniqidWithoutMoreEntropySniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return array('uniqid');
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $tokens = $phpcsFile->getTokens();

        if (count($argumentPtrs) < 2) {
            $error = sprintf('Calls to uniqid() without the $more_entropy-flag are not allowed, because they can be slow', $functionName);
            $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotGiven');
        } else {
            $moreEntropyArgumentStart = $argumentPtrs[1]['start'];
            $moreEntropyArgumentEnd = $argumentPtrs[1]['end'];
            if ($moreEntropyArgumentStart !== $moreEntropyArgumentEnd || $tokens[$moreEntropyArgumentStart]['code'] !== T_TRUE) {
                $error = sprintf('Calls to uniqid() must have the $more_entropy-flag set to true', $functionName);
                $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotTrue');
            }
        }
    }
}
