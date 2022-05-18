<?php
declare(strict_types=1);

namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;


use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

final class DisallowPrintrWithoutWrapperSniff extends AbstractFunctionCallSniff
{

	protected function registerFunctions()
	{
		return ['print_r'];
	}

	protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
	{
		if (count($argumentPtrs) < 2) {
			$error = "Do not commit code that prints directly to the console. Add 'true' or use '\MXO_Debug_Helper::print_r()'";
			$phpcsFile->addError($error, $functionNamePtr, 'Disallowed');
		}
	}

}