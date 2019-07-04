<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowDateTimeSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowDateTimeSniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowDateTimeSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowDateTimeSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            4,
            5,
            6,
            9,
            10,
            11,
        ]);

        $file = __DIR__ . '/DisallowDateTimeSniffTestWithBlockNamespace.inc';
        $this->assertFileHasErrorsOnLines($file, [
            6,
            8,
            11,
            13,
        ]);

        $file = __DIR__ . '/DisallowDateTimeSniffTestWithFileNamespace.inc';
        $this->assertFileHasErrorsOnLines($file, [
            6,
            8,
            11,
            13,
        ]);
    }
}