<?php
namespace Moxio\CodeSniffer\MoxioSniffs\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_Codesniffer\Util\Tokens;

class DisallowBareContinueInSwitchSniff implements Sniff
{
    public $supportedTokenizers = [
        'PHP',
    ];

    public function register()
    {
        return [T_SWITCH];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // We can't process SWITCH statements unless we know where they start and end.
        $hasScopeOpener = isset($tokens[$stackPtr]['scope_opener']);
        $hasScopeCloser = isset($tokens[$stackPtr]['scope_closer']);
        if ($hasScopeOpener === false || $hasScopeCloser === false) {
            return;
        }

        $switchPtr = $stackPtr;
        $switchClosePtr = $tokens[$switchPtr]['scope_closer'];

        $relevantTokens = [T_CONTINUE, T_FOR, T_FOREACH, T_WHILE, T_DO];
        $nextRelevantToken = $phpcsFile->findNext($relevantTokens, ($switchPtr + 1), $switchClosePtr);
        while ($nextRelevantToken !== false) {
            if ($tokens[$nextRelevantToken]['code'] === T_CONTINUE) {
                $continuePtr = $nextRelevantToken;

                $nextNonEmptyToken = $phpcsFile->findNext(
                    Tokens::$emptyTokens,
                    ($continuePtr + 1),
                    $switchClosePtr,
                    true
                );
                if ($tokens[$nextNonEmptyToken]['code'] === T_SEMICOLON) {
                    $error = 'A continue-statement directly inside a switch-case must have a numeric \'level\'-argument';
                    $hint = 'HINT: you probably want `continue 2`, since the switch statement is considered a looping structure';
                    $phpcsFile->addError($error . " (" . $hint . ")", $continuePtr, 'BareContinueInSwitch');
                }
            } elseif (isset($tokens[$nextRelevantToken]['scope_closer']) === true) {
                // Skip over 'real' looping structures inside the switch statement
                $nextRelevantToken = $tokens[$nextRelevantToken]['scope_closer'];
            }

            $nextRelevantToken = $phpcsFile->findNext($relevantTokens, ($nextRelevantToken + 1), $switchClosePtr);
        }
    }
}
