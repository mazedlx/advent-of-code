<?php

$strings = [
    'Frosting: capacity 4, durability -2, flavor 0, texture 0, calories 5',
    'Candy: capacity 0, durability 5, flavor -1, texture 0, calories 8',
    'Butterscotch: capacity -1, durability 0, flavor 5, texture 0, calories 6',
    'Sugar: capacity 0, durability 0, flavor -2, texture 2, calories 1'
];

$items = [];

foreach ($strings as $string) {
    preg_match_all('/\w*\:|(\w*\s-?\d)/', $string, $matches);
    $items[] = $matches[0];
}

function calc($items, $index, $tablespoons)
{
    $ingredients = array_map(function ($item) use ($index) {
        return $item[$index];
    }, $items);
    $amounts = [];

    $i = 0;
    foreach ($ingredients as $ingredient) {
        $amounts[] = (int) (explode(' ', $ingredient)[1]) * $tablespoons[$i];
        $i++;
    }
    $total = array_reduce($amounts, function ($carry, $item) {
        return $carry + $item;
    }, 0);

    if ($total < 0) {
        return 0;
    }
    return $total;
}

$totals = 0;
$tablespoons = [];
$max = 0;
for ($i = 0; $i <= 100; $i++) {
    for ($j = 0; $j <= 100-$i; $j++) {
        for ($k = 0; $k <= 100-$i-$j; $k++) {
            for ($l = 0; $l <= 100-$i-$j-$k; $l++) {
                if (($i + $j + $k + $l) == 100) {
                    $tablespoons = [$i, $j, $k, $l];

                    $capacities = calc($items, 1, $tablespoons);
                    $durabilities = calc($items, 2, $tablespoons);
                    $flavor = calc($items, 3, $tablespoons);
                    $texture = calc($items, 4, $tablespoons);
                    $calories = calc($items, 5, $tablespoons);
                    $totals = $capacities * $durabilities * $flavor * $texture;
                    if ($calories == 500 && $totals > $max) {
                        echo $i, ' ',   $j, ' ', $k, ' ', $l, ' ';
                        echo $max = $totals;
                        echo PHP_EOL;
                    }
                }
            }
        }
    }
}
