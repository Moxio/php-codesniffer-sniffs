<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowDateCreateFromFormatWithUnspecifiedTimeComponent;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowDateCreateFromFormatWithUnspecifiedTimeComponentTest extends AbstractSniffTest {
	protected function getSniffClass()
	{
		return DisallowDateCreateFromFormatWithUnspecifiedTimeComponent::class;
	}

	public function testSniff()
	{
		$file = __DIR__ . '/DisallowDateCreateFromFormatWithUnspecifiedTimeComponentTest.inc';
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
