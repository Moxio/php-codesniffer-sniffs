<?php
mb_detect_encoding('foo');
mb_detect_encoding('foo', ['UTF-8', 'ISO-8859-1']);
mb_detect_encoding('foo', ['UTF-8', 'ISO-8859-1'], true);
mb_check_encoding('foo', 'UTF-8');