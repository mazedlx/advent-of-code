<?php

$input = '12345678';
$digits = array_values(
    array_map(function ($digit) {
        return (int) $digit;
    }, str_split($input))
);

$phase = [0, 1, 0, -1];

function multi($n, $m)
{
    $m += 1;
    $m %= 4  * $n;
    if ($m < $n) {
        return 0;
    } elseif($m < 2 * $n) {
        return 1;
    } elseif ($m < 3 * $n) {
        return 0;
    } elseif ($m < 4 * $n) {
        return -1;
    }
}


$sum = [];

for ($i = 0; $i < 100; $i++) {
    for ($pos = 1; $pos <= strlen($input); $pos++) {
        $sum[$pos] = [];
        foreach ($digits as $key => $digit) {
            $i > 0 ? $key -= 1 : null;
            echo $multi($pos, $key);
            $sum[$pos][] = $digit * multi($pos, $key);
        }
        $total = array_reduce(
            $sum[$pos],
            function ($carry, $item) {
                return $carry + $item;
            },
            0
        );
        $sum[$pos] = (int) substr($total, -1, 1);
        $index = 0;
    }
    $digits = $sum;
}

echo substr(implode('', $digits), 0, 8);