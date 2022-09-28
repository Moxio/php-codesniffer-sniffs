<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowArrayCombinersWithSingleArraySniff extends AbstractFunctionCallSniff
{
    protected $skipForUnpackedArguments = true;

    private $arrayCombinationFunctions = [
        'array_merge' => 2,
        'array_merge_recursive' => 2,
        'array_replace' => 2,
        'array_replace_recursive' => 2,
        'array_diff' => 2,
        'array_diff_assoc' => 2,
        'array_diff_uassoc' => 3,
        'array_diff_key' => 2,
        'array_diff_ukey' => 3,
        'array_udiff' => 3,
        'array_udiff_assoc' => 3,
        'array_udiff_uassoc' => 4,
        'array_intersect' => 2,
        'array_intersect_assoc' => 2,
        'array_intersect_uassoc' => 3,
        'array_intersect_key' => 2,
        'array_intersect_ukey' => 3,
        'array_uintersect' => 3,
        'array_uintersect_assoc' => 3,
        'array_uintersect_uassoc' => 4,
    ];

    protected function registerFunctions()
    {
        return array_keys($this->arrayCombinationFunctions);
    }

    protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
    {
        $requiredNumArguments = $this->arrayCombinationFunctions[$functionName];
        if (count($argumentPtrs) < $requiredNumArguments) {
            $error = sprintf('Function %s must not be called with only a single array-argument', $functionName);
            $sniffCode = $this->translateFunctionNameToSniffCode($functionName);
            $phpcsFile->addError($error, $functionNamePtr, $sniffCode);
        }
    }

    private function translateFunctionNameToSniffCode($functionName)
    {
        return implode('', array_map('ucfirst', explode('_', $functionName)));
    }
}
