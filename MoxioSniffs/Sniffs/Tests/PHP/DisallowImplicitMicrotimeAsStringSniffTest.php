<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowImplicitMicrotimeAsStringSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowImplicitMicrotimeAsStringSniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowImplicitMicrotimeAsStringSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowImplicitMicrotimeAsStringSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
        ]);
    }
}
