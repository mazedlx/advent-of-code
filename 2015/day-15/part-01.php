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
    #echo implode(', ', $ingredients), PHP_EOL;
    $amounts = [];
    #echo implode(', ', $tablespoons), PHP_EOL;
    foreach ($ingredients as $key => $ingredient) {
        $amounts[] = (int) (explode(' ', $ingredient)[1]) * $tablespoons[$key];
    }

    return $amounts;
}

$totals = [];
$tablespoons = [];
for ($i = 0; $i <= 100; $i++) {
    for ($j = 0; $j <= 100 - $i; $j++) {
        for ($k = 0; $k <= 100 - $i - $j; $k++) {
            for ($l = 0; $l <= 100 - $i - $j - $k ; $l++) {
                $tablespoons = [$i, $j, $k, $l];
                if (
                    array_reduce($tablespoons, function ($carry, $item) {
                        return $carry + $item;
                    }, 0) === 100
                ) {
                #   	echo $tablespoons[0], ' ', $tablespoons[1], ' ', $tablespoons[2], ' ', $tablespoons[3], PHP_EOL;
                    $capacities = array_reduce(calc($items, 1, $tablespoons), function (
					    $carry,
					    $item
					) {
					    return $carry + $item;
					}, 0);

					$durabilities = array_reduce(calc($items, 2, $tablespoons, 0), function (
					    $carry,
					    $item
					) {
					    return $carry + $item;
					}, 0);

					$flavor = array_reduce(calc($items, 3, $tablespoons), function ($carry, $item) {
					    return $carry + $item;
					}, 0);

					$texture = array_reduce(calc($items, 4, $tablespoons), function (
					    $carry,
					    $item
					) {
					    return $carry + $item;
					}, 0);

#					echo $capacities, ' ', $durabilities, ' ', $flavor. ' ', $texture, ': ', $capacities * $durabilities * $flavor * $texture, PHP_EOL;		

					$totals[] = $capacities * $durabilities * $flavor * $texture;	
					#echo PHP_EOL;	
                }
            }
        }
    }
}
rsort($totals);
echo $totals[0], PHP_EOL;