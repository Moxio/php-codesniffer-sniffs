<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowArrayCombinersWithSingleArraySniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

class DisallowArrayCombinersWithSingleArraySniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
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
        ]);
    }
}
