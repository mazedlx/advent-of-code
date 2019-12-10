<?php

$doorId = 'ffykfhsq';
$i = 0;
$found = 0;
$password = [];

while (count($password) < 8) {
    $hash = md5($doorId . $i);
    if (substr($hash, 0, 5) === '00000') {
        $position = substr($hash, 5, 1);
        if ($position <= 7 && is_numeric($position) && !isset($password[$position])) {
            $password[$position] = substr($hash, 6, 1);
        }
    }
    $i++;
}

ksort($password);

echo implode('', $password);
