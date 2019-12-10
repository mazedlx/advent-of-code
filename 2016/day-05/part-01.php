<?php

$doorId = 'ffykfhsq';
$i = 0;
$found = 0;
while ($found < 8) {
    $hash = md5($doorId . $i);
    if (substr($hash, 0, 5) === '00000') {
        $found++;
        echo substr($hash, 5, 1);
        $i++;
    } else {
        $i++;
    }
}

