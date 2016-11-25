<?php
class Moxio_Sniffs_PHP_DisallowImplicitLooseComparisonSniff extends Moxio_Sniffs_Abstract_AbstractFunctionCallSniff
{
    private $functionsWithStrictParameter = array(
        'in_array' => 3,
        'array_search' => 3
    );

    protected function registerFunctions()
    {
        return array_keys($this->functionsWithStrictParameter);
    }

    protected function processFunctionCall(PHP_CodeSniffer_File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
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
