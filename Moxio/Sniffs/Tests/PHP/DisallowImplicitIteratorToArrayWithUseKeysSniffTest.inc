<?php
$it = new ArrayIterator([]);
iterator_to_array($it);
iterator_to_array($it, true);
iterator_to_array($it, false);
