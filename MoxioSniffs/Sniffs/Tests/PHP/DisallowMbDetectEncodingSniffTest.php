<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowMbDetectEncodingSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowMbDetectEncodingSniffTest extends AbstractSniff
{
    protected function getSniffClass()
    {
        return DisallowMbDetectEncodingSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowMbDetectEncodingSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
            3,
            4,
        ]);
    }
}
