<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowUniqidWithoutMoreEntropySniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

class DisallowUniqidWithoutMoreEntropySniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowUniqidWithoutMoreEntropySniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowUniqidWithoutMoreEntropySniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
            3,
            5,
        ]);
    }
}
