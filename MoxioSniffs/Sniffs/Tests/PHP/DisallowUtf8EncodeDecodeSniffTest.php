<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowUtf8EncodeDecodeSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTestCase;

class DisallowUtf8EncodeDecodeSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass()
    {
        return DisallowUtf8EncodeDecodeSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowUtf8EncodeDecodeSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
            6,
        ]);
    }
}
