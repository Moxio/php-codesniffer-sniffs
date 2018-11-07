<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowImplicitIteratorToArrayWithUseKeysSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniffTest;

class DisallowImplicitIteratorToArrayWithUseKeysSniffTest extends AbstractSniffTest
{
    protected function getSniffClass()
    {
        return DisallowImplicitIteratorToArrayWithUseKeysSniff::class;
    }

    public function testSniff()
    {
        $file = __DIR__ . '/DisallowImplicitIteratorToArrayWithUseKeysSniffTest.inc';
        $this->assertFileHasErrorsOnLines($file, [
            3,
        ]);
    }
}