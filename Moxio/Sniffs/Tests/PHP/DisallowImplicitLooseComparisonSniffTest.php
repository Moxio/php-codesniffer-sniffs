<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowImplicitLooseComparisonSniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

class DisallowImplicitLooseComparisonSniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowImplicitLooseComparisonSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowImplicitLooseComparisonSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
            3,
            4,
            14,
            17,
            20
        ]);
    }
}
