<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowBareContinueInSwitchSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowBareContinueInSwitchSniffTest extends AbstractSniff
{
    protected function getSniffClass()
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
