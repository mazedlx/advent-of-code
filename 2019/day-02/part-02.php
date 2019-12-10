<?php

function intcode($inputs) {
    foreach ($inputs as $key => $value) {
        $inputs[$key] = (int) $value;
    }

    for ($i = 0; $i < count($inputs);) {
        $cmd = $inputs[$i];
        if ($cmd === 1) {
            $inputs[$inputs[$i + 3]] = $inputs[$inputs[$i + 1]] + $inputs[$inputs[$i + 2]];
            $i += 4;
        } elseif ($cmd === 2) {
            $inputs[$inputs[$i + 3]] = $inputs[$inputs[$i + 1]] * $inputs[$inputs[$i + 2]];
            $i += 4;
        } elseif ($cmd === 99) {
            return $inputs[0];
            break;
        } else {
            die('error');
        }
    }
}

for($i = 0; $i <= 88; $i++) {
    for($j = 0; $j <= 88; $j++) {
        $inputs = explode(',', '1,' . $i . ',' . $j . ',3,1,1,2,3,1,3,4,3,1,5,0,3,2,6,1,19,1,19,10,23,2,13,23,27,1,5,27,31,2,6,31,35,1,6,35,39,2,39,9,43,1,5,43,47,1,13,47,51,1,10,51,55,2,55,10,59,2,10,59,63,1,9,63,67,2,67,13,71,1,71,6,75,2,6,75,79,1,5,79,83,2,83,9,87,1,6,87,91,2,91,6,95,1,95,6,99,2,99,13,103,1,6,103,107,1,2,107,111,1,111,9,0,99,2,14,0,0');

        if (intcode($inputs) === 19690720) {
            echo $i, ' ', $j;
            echo PHP_EOL;
            exit;
        }
    }
}
