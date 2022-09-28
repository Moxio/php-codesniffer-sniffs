<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowUniqidWithoutMoreEntropySniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['uniqid'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $tokens = $phpcsFile->getTokens();

        if (count($argumentPtrs) < 2) {
            $errorTemplate = 'Calls to %s() without the $more_entropy-flag are not allowed, because they can be slow';
            $error = sprintf($errorTemplate, $functionName);
            $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotGiven');
        } else {
            $moreEntropyArgumentStart = $argumentPtrs[1]['start'];
            $moreEntropyArgumentEnd = $argumentPtrs[1]['end'];
            $hasNoArgument = $moreEntropyArgumentStart !== $moreEntropyArgumentEnd;
            $hasArgumentOtherThanTrue = $tokens[$moreEntropyArgumentStart]['code'] !== T_TRUE;
            if ($hasNoArgument|| $hasArgumentOtherThanTrue) {
                $error = sprintf('Calls to %s() must have the $more_entropy-flag set to true', $functionName);
                $phpcsFile->addError($error, $functionNamePtr, 'ArgumentNotTrue');
            }
        }
    }
}
