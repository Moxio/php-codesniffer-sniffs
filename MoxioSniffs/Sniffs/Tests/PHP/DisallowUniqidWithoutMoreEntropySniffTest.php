<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowUniqidWithoutMoreEntropySniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowUniqidWithoutMoreEntropySniffTest extends AbstractSniff
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
