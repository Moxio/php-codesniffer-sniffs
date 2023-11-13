<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\PHP;

use Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP\DisallowImplicitLooseComparisonSniff;
use Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests\AbstractSniff;

class DisallowImplicitLooseComparisonSniffTest extends AbstractSniff
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
        ]);
    }
}
