<?php

$target = 29000000/10;
$houses = array_fill(0, $target, 0);

$houseNumber = $target;
for ($i = 1; $i < $target; $i++) {
  	for ($j = $i; $j < $target; $j += $i) {
    	if (($houses[$j] += $i) >= $target  && $j < $houseNumber) $houseNumber = $j;  
	}
}

echo $houseNumber, PHP_EOL;