<?php

$moons = [
    '<x=3, y=15, z=8>',
    '<x=5, y=-1, z=-2>',
    '<x=-10, y=8, z=2>',
    '<x=8, y=4, z=-5>'
];
$coords = [];
$perms = [[0, 1], [0, 2], [0, 3], [1, 2], [1, 3], [2, 3]];
foreach ($moons as $moon) {
    preg_match_all('/x=(-?\d+),\sy=(-?\d+),\sz=(-?\d+)/', $moon, $matches);
    $coords[] = [
        'pos' => [
            'x' => (int) $matches[1][0],
            'y' => (int) $matches[2][0],
            'z' => (int) $matches[3][0]
        ],
        'vel' => [
            'x' => 0,
            'y' => 0,
            'z' => 0
        ]
    ];
}

function applyGravity($coords, $pairOfMoons)
{
    foreach (['x', 'y', 'z'] as $axis) {
        $one = $coords[$pairOfMoons[0]]['pos'][$axis];
        $two = $coords[$pairOfMoons[1]]['pos'][$axis];

        if ($one > $two) {
            $coords[$pairOfMoons[0]]['vel'][$axis] -= 1;
            $coords[$pairOfMoons[1]]['vel'][$axis] += 1;
        } elseif ($one < $two) {
            $coords[$pairOfMoons[0]]['vel'][$axis] += 1;
            $coords[$pairOfMoons[1]]['vel'][$axis] -= 1;
        }
    }

    return $coords;
}

function applyVelocity($coords)
{
    foreach (range(0, 3) as $moon) {
        foreach (['x', 'y', 'z'] as $axis) {
            $coords[$moon]['pos'][$axis] += $coords[$moon]['vel'][$axis];
        }
    }

    return $coords;
}

function calcTotalEnergy($coords)
{
	foreach (range(0, 3) as $moon) {
    $potentialEnergies[$moon] = 0;
    $kineticEnergies[$moon] = 0;
    $totalEnergies[$moon] = 0;
}
    foreach (range(0, 3) as $moon) {
        foreach (['x', 'y', 'z'] as $axis) {
            $potentialEnergies[$moon] += abs($coords[$moon]['pos'][$axis]);
        }
        foreach (['x', 'y', 'z'] as $axis) {
            $kineticEnergies[$moon] += abs($coords[$moon]['vel'][$axis]);
        }
        $totalEnergies[$moon] =
            $potentialEnergies[$moon] * $kineticEnergies[$moon];
    }
  	return array_reduce($totalEnergies, function($carry, $item) {
    	return $carry + $item;
    });
}

for ($step = 0; $step < 1000; $step++) {
    foreach ($perms as $perm) {
        $coords = applyGravity($coords, $perm);
    }
    $coords = applyVelocity($coords);
}
echo calcTotalEnergy($coords), PHP_EOL;