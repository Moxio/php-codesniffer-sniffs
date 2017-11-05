Moxio PHP_CodeSniffer sniffs
=============================
This is a collection of our custom PHP_Codesniffer (3.x) sniffs for detecting potential bugs 
and unexpected behavior in PHP code. It may be used as a ruleset on its own, but it is mainly
intended as a set of separate sniffs that can be integrated into other standards.

We described the motivation behind some of these sniffs [on our blog](https://www.moxio.com/blog/10/detecting-hidden-bugs-in-php-code-using-php-codesniffer).

Installation and usage
----------------------
Install as a development dependency using composer:
```
$ composer require --dev moxio/php-codesniffer-sniffs
```
Check your files against this set of sniffs:
```
$ ./vendor/bin/phpcs --standard=vendor/moxio/php-codesniffer-sniffs/Moxio path/to/your/files
```

Description of sniffs
---------------------
_More sniffs will be added soon._

**Moxio.PHP.DisallowBareContinueInSwitch**: Disallows the `continue` statement without a numeric
argument when used directly within a `switch`-`case`. This prevents silent bugs caused by PHP 
considering `switch` [to be a looping structure](http://php.net/manual/en/control-structures.switch.php).

**Moxio.PHP.DisallowImplicitLooseComparison**: Disallows implicit non-strict comparisons by functions
like `in_array` and `array_search`. Requires that the `$strict`-parameter to these functions is
explicitly set. This prevents hidden bugs due to [counter-intuitive behavior of non-strict 
comparison](https://twitter.com/fabpot/status/460707769990266880).

**Moxio.PHP.DisallowUniqidWithoutMoreEntropy**: Disallows calls to `uniqid()` without `$more_entropy = 
true`.  When `$more_entropy` is `false` (which is the default), `uniqid()` calls `usleep()` to avoid 
collisions, which [can be a substantial performance hit](http://blog.kevingomez.fr/til/2015/07/26/why-is-uniqid-slow/).
Always calling `uniqid()` with `$more_entropy = true` avoids these problems.

**Moxio.PHP.DisallowArrayCombinersWithSingleArray**: Disallows calls to functions that combine two or more
arrays with only a single array given as an argument. This applies to functions like `array_merge(_recursive)`, 
`array_replace(_recursive)` and all variants of `array_diff` and `array_intersect`. Such a call does not make sense,
and is most likely a result of a misplaced comma or parenthesis. To re-index a single array, just use `array_values`.

Running tests
-------------
After installing dependencies (including development dependencies) using Composer, run
```
$ ./vendor/bin/phpunit
```
from the project root dir.

Versioning
----------
This project adheres to [Semantic Versioning](http://semver.org/).

Please note that, from the perspective of this library as a pick-and-match collection of sniffs (and not
a complete coding standard), the addition of new sniffs will not be considered a breaking change and thus
does not cause an increase in the major version number.  

License
-------
These sniffs are released under the MIT license.
