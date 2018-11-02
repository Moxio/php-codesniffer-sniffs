<?php
namespace Moxio\Sniffs\Tests\PHP;

use Moxio\Sniffs\PHP\DisallowImplicitIteratorToArrayWithUseKeysSniff;
use Moxio\Sniffs\Tests\AbstractSniffTest;

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