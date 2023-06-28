<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

class DisallowDateCreateFromFormatWithUnspecifiedTimeComponentSniff extends AbstractFunctionCallSniff
{
	private const TIME_COMPONENTS = 'ghGHisvu';

	public $supportedTokenizers = [
		'PHP',
	];

	public function registerFunctions(): array
	{
		return [
			'\DateTime::createFromFormat',
			'\DateTimeImmutable::createFromFormat',
			'date_create_from_format',
			'date_create_immutable_from_format',
		];
	}

	protected function processFunctionCall(File $phpcsFile, $functionName, $functionNamePtr, $argumentPtrs)
	{
		$tokens = $phpcsFile->getTokens();

		if (count($argumentPtrs) > 0) {
			$formatArgumentStart = $argumentPtrs[0]['start'];
			$formatArgumentEnd = $argumentPtrs[0]['end'];
			if ($formatArgumentStart !== $formatArgumentEnd || $tokens[$formatArgumentStart]['code'] !== T_CONSTANT_ENCAPSED_STRING) {
				return;
			}

			$format = substr($tokens[$formatArgumentStart]['content'], 1, -1);
			if (self::formatContainsTimeComponent($format) === false && $format[0] !== '!' && $format[-1] !== '|') {
				$phpcsFile->addError('Date creation formats without a time component should be initialized to null.', $formatArgumentStart, 'ArgumentNotTrue');
			}
		}
	}

	private static function formatContainsTimeComponent(string $format): bool {
		for ($i = 0; $i < strlen(self::TIME_COMPONENTS); $i++) {
			if (strpos($format, self::TIME_COMPONENTS[$i]) !== false) {
				return true;
			}
		}
		return false;
	}
}
