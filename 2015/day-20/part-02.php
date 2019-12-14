<?php

$target = 29000000/10;
$houses = array_fill(0, $target, 0);
$houseNumber = $target;

for ($i = 1; $i < $target; $i++) {
  $visits = 0;
  for ($j = $i; $j < $target; $j += $i) {
    if (($houses[$j] = ($houses[$j] ?: 11) + $i * 11) >= $target * 10 && $j < $houseNumber) $houseNumber = $j;

    $visits++;
    if ($visits === 50) break;
  }
}

echo $houseNumber, PHP_EOL;