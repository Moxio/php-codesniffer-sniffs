<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowPrintrWithoutWrapperSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowPrintrWithoutWrapperSniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowPrintrWithoutWrapperSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowPrintrWithoutWrapperSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
            3,
            4,
        ]);
    }
}
