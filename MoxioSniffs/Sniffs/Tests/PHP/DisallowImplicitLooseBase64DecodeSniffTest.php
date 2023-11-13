<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowImplicitLooseBase64DecodeSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowImplicitLooseBase64DecodeSniffTest extends AbstractSniff
{
    protected function getSniffClass()
    {
        return DisallowImplicitLooseBase64DecodeSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowImplicitLooseBase64DecodeSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            2,
        ]);
    }
}
