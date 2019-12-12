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
$sizes = [];
for ($i = 1; $i <= count($containers); $i++) {
	$sizes[$i] = 0;
}
for($i = 0; $i < 2**count($containers) ; $i++){
	foreach(str_split(strrev(decbin($i))) as $key => $digit) {
		if ($digit == 1) {
			$filled[] = $containers[$key];	
		}
	}
	if(array_reduce($filled, function($carry, $item) {
		return $carry + $item;
	}, 0) === $max) {
		$sizes[count($filled)] += 1;
		$count++;
	}
	$filled = [];
}
$sizes = array_filter($sizes, function($item) {
	return $item > 0;
});
$sizes = array_values($sizes);
sort($sizes);
echo $sizes[0], PHP_EOL;
