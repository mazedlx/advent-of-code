<?php

function checkAdj($grid, $x, $y)
{
    $bugs = 0;
    if ($x > 0) {
        $left = $x - 1;
        $bugs += $grid[$left . '/' . $y] === '#' ? 1 : 0;
    }
    if ($x < 4) {
        $right = $x + 1;
        $bugs += $grid[$right . '/' . $y] === '#' ? 1 : 0;
    }
    if ($y < 4) {
        $top = $y + 1;
        $bugs += $grid[$x . '/' . $top] === '#' ? 1 : 0;
    }
    if ($y > 0) {
        $bottom = $y - 1;
        $bugs += $grid[$x . '/' . $bottom] === '#' ? 1 : 0;
    }
    return $bugs;
}

$eris = [];
$seen = [];
$grid = '#.#..
.....
.#.#.
.##..
.##.#';

$grid = explode(PHP_EOL, $grid);
foreach ($grid as $row => $line) {
    $tiles = str_split($line);
    foreach ($tiles as $col => $tile) {
        $eris["$row/$col"] = $tile;
    }
}

$found = false;
while (!$found) {
    $seen[] = $eris;
    $copy = $eris;

    for ($y = 0; $y <= 4; $y++) {
        for ($x = 0; $x <= 4; $x++) {
            if (
                $copy["$x/$y"] === '.' &&
                in_array(checkAdj($copy, $x, $y), [1, 2])
            ) {
                $eris["$x/$y"] = '#';
            } elseif ($copy["$x/$y"] === '#' && checkAdj($copy, $x, $y) !== 1) {
                $eris["$x/$y"] = '.';
            }
        }
    }
    if (in_array($eris, $seen)) {
        $found = true;
    }
}

$i = 0;
$sum = 0;
for ($x = 0; $x <= 4; $x++) {
    for ($y = 0; $y <= 4; $y++) {
        echo $eris["$x/$y"];
        if ($eris["$x/$y"] === '#') {
            $sum += 2 ** $i;
        }
        $i++;
    }

    echo PHP_EOL;
}
echo PHP_EOL;

echo $sum, PHP_EOL;


