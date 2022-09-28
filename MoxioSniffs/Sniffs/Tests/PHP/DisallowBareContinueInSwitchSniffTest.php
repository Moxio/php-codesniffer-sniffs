<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowBareContinueInSwitchSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowBareContinueInSwitchSniffTest extends AbstractSniffTest
{
    protected function getSniffClass(): string
    {
        return DisallowBareContinueInSwitchSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowBareContinueInSwitchSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            5,
        ]);
    }
}
