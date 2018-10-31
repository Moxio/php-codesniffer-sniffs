<?php
for ($i = 1; $i < 10; $i++) {
    switch ($x) {
        case "foo":
            continue;           // NOT OK, probably a bug
        case "bar":
            foreach ($a as $k => $v) {
                continue;       // OK, inside a new loop
            }
            continue 2;         // OK, explicit number of levels
    }
}