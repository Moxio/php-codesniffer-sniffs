<?php

namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Sniffs\Sniff;

require_once __DIR__ . '/../../../vendor/squizlabs/php_codesniffer/autoload.php';

abstract class AbstractSniffTest extends \PHPUnit\Framework\TestCase
{
    /** @return class-string<Sniff> */
    abstract protected function getSniffClass(): string;

    protected function assertFileHasErrorsOnLines($file, $lines): void
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
