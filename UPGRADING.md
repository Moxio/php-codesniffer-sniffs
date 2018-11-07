Upgrading
=========

Upgrading to 2.0
----------------

* The name of this standard has been changed from `Moxio` to `MoxioSniffs`. Additionally the
  associated PHP namespace has been changed from `Moxio\Sniffs` to `Moxio\CodeSniffer\MoxioSniffs\Sniffs`. 
  This is meant to emphasize the character of this 'standard' as a set of _pick-and-match_ 
  sniffs rather than a complete coding standard, and to prevent naming conflicts with our 
  internal company coding standard.
  - All references to individual sniffs (or the complete set) by name should have the `Moxio` 
    standard name changed to `MoxioSniffs`.
  - All references to sniffs by PHP namespace (e.g. when extending a sniff) should use the 
  `Moxio\CodeSniffer\MoxioSniffs\Sniffs` namespace instead of `Moxio\Sniffs`.
  - When referring to sniffs by path, take note that the `Moxio`-directory has been renamed
    to `MoxioSniffs` to reflect the new namespace.
  