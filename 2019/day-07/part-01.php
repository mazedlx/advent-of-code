<?php

function getValue($inputs, $i, $mode)
{
    if ((int) $mode === 0) {
        return $inputs[$inputs[$i]];
    }
    return $inputs[$i];
}

function intcode($inputs, $phase, $signal)
{
    foreach ($inputs as $key => $value) {
        $inputs[$key] = (int) $value;
    }
    $z = 0;
    for ($i = 0; $i < count($inputs);) {
        $cmd = (int) substr($inputs[$i], -2, 4);
        $mode = [0, 0];
        if ($inputs[$i] > 99) {
            $mode = str_split(strrev(substr($inputs[$i], 0, strlen($inputs[$i]) - 2)));
            if (count($mode) < 2) {
                $mode[1] = 0;
            }
        }
        if ($cmd === 1) {
            $inputs[$inputs[$i + 3]] =
                getValue($inputs, $i + 1, $mode[0]) +
                getValue($inputs, $i + 2, $mode[1]);
            $i += 4;
        } elseif ($cmd === 2) {
            $inputs[$inputs[$i + 3]] =  getValue($inputs, $i + 1, $mode[0]) *
                getValue($inputs, $i + 2, $mode[1]);
            $i += 4;
        } elseif ($cmd === 3) {
            $inputs[$inputs[$i + 1]] = ($z === 0 ? $phase : $signal);
            $z++;   
            $i += 2;
        } elseif ($cmd === 4) {
            return getValue($inputs, $i + 1, $mode[0]);
            $i += 2;
        } elseif ($cmd === 5) {
            if (getValue($inputs, $i + 1, $mode[0]) !== 0) {
                $i = getValue($inputs, $i + 2, $mode[1]);
            } else {
                $i+=3;
            }
        } elseif ($cmd === 6) {
            if (getValue($inputs, $i + 1, $mode[0]) === 0) {
                $i = getValue($inputs, $i + 2, $mode[1]);
            } else {
                $i+=3;
            }
        } elseif ($cmd === 7) {
            if (getValue($inputs, $i + 1, $mode[0]) < getValue($inputs, $i + 2, $mode[1])) {
                $inputs[$inputs[$i+3]] = 1;
            } else {
                $inputs[$inputs[$i+3]] = 0;
            }
            $i+=4;
        } elseif ($cmd === 8) {
            if (getValue($inputs, $i + 1, $mode[0]) === getValue($inputs, $i + 2, $mode[1])) {
                $inputs[$inputs[$i+3]] = 1;
            } else {
                $inputs[$inputs[$i+3]] = 0;
            }
            $i+=4;
        } elseif ($cmd === 99) {
            return;
        } else {
            die('error' . $cmd);
        }
    }
}

$inputs = explode(
    ',',
    '3,8,1001,8,10,8,105,1,0,0,21,38,47,64,85,106,187,268,349,430,99999,3,9,1002,9,4,9,1001,9,4,9,1002,9,4,9,4,9,99,3,9,1002,9,4,9,4,9,99,3,9,1001,9,3,9,102,5,9,9,1001,9,5,9,4,9,99,3,9,101,3,9,9,102,5,9,9,1001,9,4,9,102,4,9,9,4,9,99,3,9,1002,9,3,9,101,2,9,9,102,4,9,9,101,2,9,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,3,9,101,1,9,9,4,9,99,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,101,1,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,102,2,9,9,4,9,99'
);

function permutate($items)
{
    $perms = [];
    
    $recurse = function($items, $start_i = 0) use (&$perms, &$recurse) {
        if ($start_i === count($items)-1) {
            array_push($perms, $items);
        }

        for ($i = $start_i; $i < count($items); $i++) {
            $t = $items[$i]; $items[$i] = $items[$start_i]; $items[$start_i] = $t;
            $recurse($items, $start_i + 1);
            $t = $items[$i]; $items[$i] = $items[$start_i]; $items[$start_i] = $t;
        }
    };

    $recurse($items);
    return $perms;
}

function findHighestSignal($inputs) {
    $max = 0;
    foreach (permutate(range(0, 4)) as $perm) {
        [$a, $b, $c, $d, $e] = $perm;

        $outputA = intcode($inputs, $a, 0);
        $outputB = intcode($inputs, $b, $outputA);
        $outputC = intcode($inputs, $c, $outputB);
        $outputD = intcode($inputs, $d, $outputC);
        $outputE = intcode($inputs, $e, $outputD);
        if ($outputE > $max) {
            $max = $outputE;
        }
    }
    return $max;
}

echo findHighestSignal($inputs) . PHP_EOL;
