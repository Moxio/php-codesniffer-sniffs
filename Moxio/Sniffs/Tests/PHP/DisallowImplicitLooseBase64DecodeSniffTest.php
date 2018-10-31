<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowImplicitLooseBase64DecodeSniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

class DisallowImplicitLooseBase64DecodeSniffTest extends AbstractSniffTest
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
