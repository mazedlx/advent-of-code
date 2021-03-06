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

function gcd($a, $b)
{
 	return $a ? gcd($b % $a, $a) : $b;
}

function lcm($a, $b) {
	return ($a * $b)/gcd($a, $b);
}

$initial = $coords;
$periods = [];
for ($step = 1; $step < 1000000; $step++) {
    foreach ($perms as $perm) {
        $coords = applyGravity($coords, $perm);
    }
    $coords = applyVelocity($coords);

    if ($coords[0]['pos']['x'] === $initial[0]['pos']['x'] && 
    	$coords[1]['pos']['x'] === $initial[1]['pos']['x'] && 
    	$coords[2]['pos']['x'] === $initial[2]['pos']['x'] && 
    	$coords[3]['pos']['x'] === $initial[3]['pos']['x'] && 
		!isset($periods['x'])
	) {
		$periods['x'] = $step + 1;
	}
	if ($coords[0]['pos']['y'] === $initial[0]['pos']['y'] && 
    	$coords[1]['pos']['y'] === $initial[1]['pos']['y'] && 
    	$coords[2]['pos']['y'] === $initial[2]['pos']['y'] && 
    	$coords[3]['pos']['y'] === $initial[3]['pos']['y'] && 
		!isset($periods['y'])
	) {
		$periods['y'] = $step + 1;
	}
	if ($coords[0]['pos']['z'] === $initial[0]['pos']['z'] && 
    	$coords[1]['pos']['z'] === $initial[1]['pos']['z'] && 
    	$coords[2]['pos']['z'] === $initial[2]['pos']['z'] && 
    	$coords[3]['pos']['z'] === $initial[3]['pos']['z'] && 
		!isset($periods['z'])
	) {
		$periods['z'] = $step + 1;
	}
	if (count($periods) === 3) {
		echo implode(', ', $periods), ', Rotations: ', lcm($periods['z'], lcm($periods['x'], $periods['y'])), PHP_EOL;
		exit;
	}
}