<?php

$y = 0;
$x = 0;
$val = 1;
$grid["$x/$y"] = $val;
$val++;
$target = 361527;
for ($i = 1; $i <= 650; $i++) {
    if ($i % 2 === 0) {
        for ($j = 0; $j < $i; $j++) {
            $x -= 1;
            $grid["$x/$y"] = $val;
            if ($val === $target) {
                echo "$x/$y";
            }
            $val++;
        }
        for ($j = 0; $j < $i; $j++) {
            $y -= 1;
            $grid["$x/$y"] = $val;
            if ($val === $target) {
                echo "$x/$y";
            }
            $val++;
        }
    } else {
        for ($j = 0; $j < $i; $j++) {
            $x += 1;
            $grid["$x/$y"] = $val;
            if ($val === $target) {
                echo "$x/$y";
            }
            $val++;
        }
        for ($j = 0; $j < $i; $j++) {
            $y += 1;
            $grid["$x/$y"] = $val;
            if ($val === $target) {
                echo "$x/$y";
            }
            $val++;
        }
    }
}



