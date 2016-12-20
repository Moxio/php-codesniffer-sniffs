<?php
namespace Moxio\Sniffs\PHP;

use Moxio\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowImplicitLooseComparisonSniff extends AbstractFunctionCallSniff
{
    private $functionsWithStrictParameter = array(
        'in_array' => 3,
        'array_search' => 3
    );

    protected function registerFunctions()
    {
        return array_keys($this->functionsWithStrictParameter);
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $requiredNumArguments = $this->functionsWithStrictParameter[$functionName];
        if (count($argumentPtrs) < $requiredNumArguments) {
            $error = sprintf('The $strict-parameter to %s must be explicitly set', $functionName);
            $sniffCode = $this->translateFunctionNameToSniffCode($functionName);
            $phpcsFile->addError($error, $functionNamePtr, $sniffCode);
        }
    }

    private function translateFunctionNameToSniffCode($functionName)
    {
        return implode('', array_map('ucfirst', explode('_', $functionName)));
    }
}
