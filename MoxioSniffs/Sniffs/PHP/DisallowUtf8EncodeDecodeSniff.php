<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowUtf8EncodeDecodeSniff extends AbstractFunctionCallSniff
{
    protected function registerFunctions()
    {
        return ['utf8_encode', 'utf8_decode'];
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $error = sprintf('Using %s() is not allowed; use iconv() or mb_convert_encoding() instead', $functionName);
        $sniffCode = $this->translateFunctionNameToSniffCode($functionName);
        $phpcsFile->addError($error, $functionNamePtr, $sniffCode);
    }

    private function translateFunctionNameToSniffCode($functionName)
    {
        return implode('', array_map('ucfirst', explode('_', $functionName)));
    }
}
