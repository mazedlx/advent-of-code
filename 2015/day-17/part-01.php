<?php

$containers = [
	1,
	13,
	13,
	14,
	16,
	18,
	18,
	20,
	24,
	30,
	33,
	35,
	35,
	41,
	42,
	44,
	45,
	48,
	50,
	6,
];

$max = 150;
$count = 0;
$filled = [];
for($i = 0; $i < 2**count($containers) ; $i++){
	foreach(str_split(strrev(decbin($i))) as $key => $digit) {
		if ($digit == 1) {
			$filled[] = $containers[$key];	
		}
	}
	if(array_reduce($filled, function($carry, $item) {
		return $carry + $item;
	}, 0) === $max) {
		$count++;
	}
	$filled = [];
}

echo $count, PHP_EOL;