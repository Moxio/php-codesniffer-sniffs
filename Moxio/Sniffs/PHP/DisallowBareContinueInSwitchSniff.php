<?php
namespace Moxio\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_Codesniffer\Util\Tokens;

class DisallowBareContinueInSwitchSniff implements Sniff
{
    public $supportedTokenizers = array(
        'PHP',
    );

    public function register()
    {
        return array(T_SWITCH);
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // We can't process SWITCH statements unless we know where they start and end.
        if (isset($tokens[$stackPtr]['scope_opener']) === false || isset($tokens[$stackPtr]['scope_closer']) === false) {
            return;
        }

        $switchPtr = $stackPtr;
        $switchClosePtr = $tokens[$switchPtr]['scope_closer'];

        $nextRelevantToken = $switchPtr;
        while (($nextRelevantToken = $phpcsFile->findNext(array(T_CONTINUE, T_FOR, T_FOREACH, T_WHILE, T_DO), ($nextRelevantToken + 1), $switchClosePtr)) !== false) {
            if ($tokens[$nextRelevantToken]['code'] === T_CONTINUE) {
                $continuePtr = $nextRelevantToken;

                $nextNonEmptyToken = $phpcsFile->findNext(Tokens::$emptyTokens, ($continuePtr + 1), $switchClosePtr, true);
                if ($tokens[$nextNonEmptyToken]['code'] === T_SEMICOLON) {
                    $error = 'A continue-statement directly inside a switch-case must have a numeric \'level\'-argument';
                    $hint = 'HINT: you probably want `continue 2`, since the switch statement is considered a looping structure';
                    $phpcsFile->addError($error . " (" . $hint . ")", $continuePtr, 'BareContinueInSwitch');
                }
            } elseif (isset($tokens[$nextRelevantToken]['scope_closer']) === true) {
                // Skip over 'real' looping structures inside the switch statement
                $nextRelevantToken = $tokens[$nextRelevantToken]['scope_closer'];
            }
        }
    }
}
