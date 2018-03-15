<?php
namespace Moxio\Sniffs\PHP;

use Moxio\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowImplicitLooseComparisonSniff extends AbstractFunctionCallSniff
{
    private $functionsWithStrictParameter = array(
        'in_array' => 3,
        'array_search' => 3,
        'array_keys' => 3,
    );

    private $minimumArgumentsForApplicability = array(
        'array_keys' => 2,
    );

    protected function registerFunctions()
    {
        return array_keys($this->functionsWithStrictParameter);
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $requiredNumArguments = $this->functionsWithStrictParameter[$functionName];
        $numArguments = count($argumentPtrs);

        if (isset($this->minimumArgumentsForApplicability[$functionName])) {
            $applicabilityNumArguments = $this->minimumArgumentsForApplicability[$functionName];
            if ($numArguments < $applicabilityNumArguments) {
                return;
            }
            $errorRestriction = sprintf(' when called with at least %d arguments', $applicabilityNumArguments);
        } else {
            $errorRestriction = '';
        }

        if ($numArguments < $requiredNumArguments) {
            $error = sprintf('The $strict-parameter to %s must be explicitly set', $functionName) . $errorRestriction;
            $sniffCode = $this->translateFunctionNameToSniffCode($functionName);
            $phpcsFile->addError($error, $functionNamePtr, $sniffCode);
        }
    }

    private function translateFunctionNameToSniffCode($functionName)
    {
        return implode('', array_map('ucfirst', explode('_', $functionName)));
    }
}
