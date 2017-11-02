<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowBareContinueInSwitchSniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

class DisallowBareContinueInSwitchSniffTest extends AbstractSniffTest
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
