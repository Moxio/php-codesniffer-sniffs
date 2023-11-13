<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowDateCreateFromFormatWithUnspecifiedTimeComponentSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowDateCreateFromFormatWithUnspecifiedTimeComponentSniffTest extends AbstractSniff {
	protected function getSniffClass()
	{
		return DisallowDateCreateFromFormatWithUnspecifiedTimeComponentSniff::class;
	}

	public function testSniff()
	{
		$file = __DIR__ . '/DisallowDateCreateFromFormatWithUnspecifiedTimeComponentSniffTest.inc';
		$this->assertFileHasErrorsOnLines($file, [
			2,
			6,
			10,
			14,
			18,
			22,
		]);
	}
}
