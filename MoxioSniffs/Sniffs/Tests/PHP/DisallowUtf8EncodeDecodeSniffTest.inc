<?php
utf8_encode('foo');
iconv('ISO-8859-1', 'UTF-8', 'foo');
mb_convert_encoding('foo', 'UTF-8', 'ISO-8859-1');

utf8_decode('foo');
iconv('UTF-8', 'ISO-8859-1', 'foo');
mb_convert_encoding('foo', 'ISO-8859-1', 'UTF-8');
