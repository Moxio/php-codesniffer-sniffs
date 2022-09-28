<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowArrayCombinersWithSingleArraySniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowArrayCombinersWithSingleArraySniffTest extends AbstractSniffTest
{
    protected function getSniffClass(): string
    {
        return DisallowArrayCombinersWithSingleArraySniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowArrayCombinersWithSingleArraySniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            3,
            5,
            7,
            9,
            11,
            13,
            15,
            17,
            19,
            21,
            23,
            25,
            27,
            29,
            31,
            33,
            35,
            37,
            39,
            41,
            43,
            46,
        ]);
    }
}
