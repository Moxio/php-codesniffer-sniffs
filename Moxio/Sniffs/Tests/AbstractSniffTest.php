<?php
namespace Moxio\Sniffs\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;

require_once __DIR__ . '/../../../vendor/squizlabs/php_codesniffer/autoload.php';

abstract class AbstractSniffTest extends \PHPUnit\Framework\TestCase
{
    abstract protected function getSniffClass();

    protected function assertFileHasErrorsOnLines($file, $lines)
    {
        $phpcs = new Runner();
        $phpcs->config = new Config(['-q']);
        $phpcs->init();

        $phpcs->ruleset->sniffs = [
            $this->getSniffClass() => $this->getSniffClass()
        ];
        $phpcs->ruleset->populateTokenListeners();

        $phpcsFile = new LocalFile($file, $phpcs->ruleset, $phpcs->config);
        $phpcsFile->process();

        $linesWithErrors = array_keys($phpcsFile->getErrors());
        $this->assertEquals($lines, $linesWithErrors);
    }
}
