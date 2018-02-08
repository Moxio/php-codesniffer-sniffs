<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowImplicitLooseComparisonSniff;
use Moxio\Sniffs\PHP\DisallowImplicitMicrotimeAsStringSniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

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
