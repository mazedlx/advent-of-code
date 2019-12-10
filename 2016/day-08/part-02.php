<?php

$width = 50;
$height = 6;
$display = [];
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $display[$x . '/' . $y] = ' ';
    }
}

$instructions = [
    'rect 1x1',
    'rotate row y=0 by 5',
    'rect 1x1',
    'rotate row y=0 by 5',
    'rect 1x1',
    'rotate row y=0 by 3',
    'rect 1x1',
    'rotate row y=0 by 2',
    'rect 1x1',
    'rotate row y=0 by 3',
    'rect 1x1',
    'rotate row y=0 by 2',
    'rect 1x1',
    'rotate row y=0 by 5',
    'rect 1x1',
    'rotate row y=0 by 5',
    'rect 1x1',
    'rotate row y=0 by 3',
    'rect 1x1',
    'rotate row y=0 by 2',
    'rect 1x1',
    'rotate row y=0 by 3',
    'rect 2x1',
    'rotate row y=0 by 2',
    'rect 1x2',
    'rotate row y=1 by 5',
    'rotate row y=0 by 3',
    'rect 1x2',
    'rotate column x=30 by 1',
    'rotate column x=25 by 1',
    'rotate column x=10 by 1',
    'rotate row y=1 by 5',
    'rotate row y=0 by 2',
    'rect 1x2',
    'rotate row y=0 by 5',
    'rotate column x=0 by 1',
    'rect 4x1',
    'rotate row y=2 by 18',
    'rotate row y=0 by 5',
    'rotate column x=0 by 1',
    'rect 3x1',
    'rotate row y=2 by 12',
    'rotate row y=0 by 5',
    'rotate column x=0 by 1',
    'rect 4x1',
    'rotate column x=20 by 1',
    'rotate row y=2 by 5',
    'rotate row y=0 by 5',
    'rotate column x=0 by 1',
    'rect 4x1',
    'rotate row y=2 by 15',
    'rotate row y=0 by 15',
    'rotate column x=10 by 1',
    'rotate column x=5 by 1',
    'rotate column x=0 by 1',
    'rect 14x1',
    'rotate column x=37 by 1',
    'rotate column x=23 by 1',
    'rotate column x=7 by 2',
    'rotate row y=3 by 20',
    'rotate row y=0 by 5',
    'rotate column x=0 by 1',
    'rect 4x1',
    'rotate row y=3 by 5',
    'rotate row y=2 by 2',
    'rotate row y=1 by 4',
    'rotate row y=0 by 4',
    'rect 1x4',
    'rotate column x=35 by 3',
    'rotate column x=18 by 3',
    'rotate column x=13 by 3',
    'rotate row y=3 by 5',
    'rotate row y=2 by 3',
    'rotate row y=1 by 1',
    'rotate row y=0 by 1',
    'rect 1x5',
    'rotate row y=4 by 20',
    'rotate row y=3 by 10',
    'rotate row y=2 by 13',
    'rotate row y=0 by 10',
    'rotate column x=5 by 1',
    'rotate column x=3 by 3',
    'rotate column x=2 by 1',
    'rotate column x=1 by 1',
    'rotate column x=0 by 1',
    'rect 9x1',
    'rotate row y=4 by 10',
    'rotate row y=3 by 10',
    'rotate row y=1 by 10',
    'rotate row y=0 by 10',
    'rotate column x=7 by 2',
    'rotate column x=5 by 1',
    'rotate column x=2 by 1',
    'rotate column x=1 by 1',
    'rotate column x=0 by 1',
    'rect 9x1',
    'rotate row y=4 by 20',
    'rotate row y=3 by 12',
    'rotate row y=1 by 15',
    'rotate row y=0 by 10',
    'rotate column x=8 by 2',
    'rotate column x=7 by 1',
    'rotate column x=6 by 2',
    'rotate column x=5 by 1',
    'rotate column x=3 by 1',
    'rotate column x=2 by 1',
    'rotate column x=1 by 1',
    'rotate column x=0 by 1',
    'rect 9x1',
    'rotate column x=46 by 2',
    'rotate column x=43 by 2',
    'rotate column x=24 by 2',
    'rotate column x=14 by 3',
    'rotate row y=5 by 15',
    'rotate row y=4 by 10',
    'rotate row y=3 by 3',
    'rotate row y=2 by 37',
    'rotate row y=1 by 10',
    'rotate row y=0 by 5',
    'rotate column x=0 by 3',
    'rect 3x3',
    'rotate row y=5 by 15',
    'rotate row y=3 by 10',
    'rotate row y=2 by 10',
    'rotate row y=0 by 10',
    'rotate column x=7 by 3',
    'rotate column x=6 by 3',
    'rotate column x=5 by 1',
    'rotate column x=3 by 1',
    'rotate column x=2 by 1',
    'rotate column x=1 by 1',
    'rotate column x=0 by 1',
    'rect 9x1',
    'rotate column x=19 by 1',
    'rotate column x=10 by 3',
    'rotate column x=5 by 4',
    'rotate row y=5 by 5',
    'rotate row y=4 by 5',
    'rotate row y=3 by 40',
    'rotate row y=2 by 35',
    'rotate row y=1 by 15',
    'rotate row y=0 by 30',
    'rotate column x=48 by 4',
    'rotate column x=47 by 3',
    'rotate column x=46 by 3',
    'rotate column x=45 by 1',
    'rotate column x=43 by 1',
    'rotate column x=42 by 5',
    'rotate column x=41 by 5',
    'rotate column x=40 by 1',
    'rotate column x=33 by 2',
    'rotate column x=32 by 3',
    'rotate column x=31 by 2',
    'rotate column x=28 by 1',
    'rotate column x=27 by 5',
    'rotate column x=26 by 5',
    'rotate column x=25 by 1',
    'rotate column x=23 by 5',
    'rotate column x=22 by 5',
    'rotate column x=21 by 5',
    'rotate column x=18 by 5',
    'rotate column x=17 by 5',
    'rotate column x=16 by 5',
    'rotate column x=13 by 5',
    'rotate column x=12 by 5',
    'rotate column x=11 by 5',
    'rotate column x=3 by 1',
    'rotate column x=2 by 5',
    'rotate column x=1 by 5',
    'rotate column x=0 by 1'
];

foreach ($instructions as $instruction) {
    $copy = [];
    if (strstr($instruction, 'rect')) {
        $target = explode('x', explode(' ', $instruction)[1]);
        for ($x = 0; $x < $target[0]; $x++) {
            for ($y = 0; $y < $target[1]; $y++) {
                $display[$x . '/' . $y] = '#';
            }
        }
    }
    if (strstr($instruction, 'rotate')) {
        $rowOrCol = explode(' ', $instruction)[1];
        $start = explode('=', explode(' ', $instruction)[2])[1];
        $steps = explode(' ', $instruction)[4];

        if ($rowOrCol === 'row') {
            $copy = $display;
            foreach ($copy as $key => $value) {
                if (explode('/', $key)[1] == $start) {
                    $newX = explode('/', $key)[0] + $steps;
                    if ($newX > $width - 1) {
                        $newX = $newX - $width;
                    }
                    $newKey = $newX . '/' . explode('/', $key)[1];

                    $display[$newKey] = $copy[$key];
                }
            }
        } else {
            $copy = $display;
            foreach ($copy as $key => $value) {
                if (explode('/', $key)[0] == $start) {
                    $newY = explode('/', $key)[1] + $steps;
                    if ($newY > $height - 1) {
                        $newY = $newY - $height;
                    }
                    $newKey = explode('/', $key)[0] . '/' . $newY;

                    $display[$newKey] = $copy[$key];
                }
            }
        }
    }
}

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        echo $display[$x . '/' . $y];
    }
    echo PHP_EOL;
}

