<?php

namespace Foo {
    use DateTime as DateTimeAlias;

    $dt = new \DateTime();
    $fooDt = new DateTime();
    $dt = new DateTimeAlias();
    $dti = new \DateTimeImmutable();

    \DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
    DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
    DateTimeAlias::createFromFormat('j-M-Y', '15-Feb-2009');
    \DateTimeImmutable::createFromFormat('j-M-Y', '15-Feb-2009');
}