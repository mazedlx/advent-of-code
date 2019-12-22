<?php

function getVal($grid, $x, $y)
{
    $val = 0;
    if (isset($grid[$x - 1 . '/' . ($y - 1)])) {
        $val += $grid[$x - 1 . '/' . ($y - 1)];
    }
    if (isset($grid[$x - 1 . '/' . $y])) {
        $val += $grid[$x - 1 . '/' . $y];
    }
    if (isset($grid[$x - 1 . '/' . ($y + 1)])) {
        $val += $grid[$x - 1 . '/' . ($y + 1)];
    }
    if (isset($grid[$x + 1 . '/' . ($y - 1)])) {
        $val += $grid[$x + 1 . '/' . ($y - 1)];
    }
    if (isset($grid[$x + 1 . '/' . $y])) {
        $val += $grid[$x + 1 . '/' . $y];
    }
    if (isset($grid[$x + 1 . '/' . ($y + 1)])) {
        $val += $grid[$x + 1 . '/' . ($y + 1)];
    }
    if (isset($grid[$x . '/' . ($y - 1)])) {
        $val += $grid[$x . '/' . ($y - 1)];
    }
    if (isset($grid[$x . '/' . ($y + 1)])) {
        $val += $grid[$x . '/' . ($y + 1)];
    }
    if ($val >= 361527) {
        echo $val, PHP_EOL;
        exit();
    }
    return $val;
}

$y = 0;
$x = 0;
$val = 1;
$grid["$x/$y"] = $val;
$target = 361527;
for ($i = 1; $i <= 50; $i++) {
    if ($i % 2 === 0) {
        for ($j = 0; $j < $i; $j++) {
            $x -= 1;
            $grid["$x/$y"] = getVal($grid, $x, $y);
        }
        for ($j = 0; $j < $i; $j++) {
            $y -= 1;
            $grid["$x/$y"] = getVal($grid, $x, $y);
        }
    } else {
        for ($j = 0; $j < $i; $j++) {
            $x += 1;
            $grid["$x/$y"] = getVal($grid, $x, $y);
        }
        for ($j = 0; $j < $i; $j++) {
            $y += 1;
            $grid["$x/$y"] = getVal($grid, $x, $y);
        }
    }
}


