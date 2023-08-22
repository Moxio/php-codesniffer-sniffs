<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowImplicitMicrotimeAsStringSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowImplicitMicrotimeAsStringSniffTest extends AbstractSniff
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
