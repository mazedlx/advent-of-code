<?php
$input =
  '17,x,x,x,x,x,x,x,x,x,x,37,x,x,x,x,x,907,x,x,x,x,x,x,x,x,x,x,x,19,x,x,x,x,x,x,x,x,x,x,23,x,x,x,x,x,29,x,653,x,x,x,x,x,x,x,x,x,41,x,x,13';

$map = [];
$buses = collect(explode(',', $input))
  ->filter(function ($bus) {
    return $bus !== 'x';
  })
  ->map(function ($bus) {
    return (int) $bus;
  });
$multiplier = 1;
$i = 0;

foreach ($buses->toArray() as $index => $bus) {
  while (true) {
    if (($i + $index) % $bus === 0) {
      $multiplier *= $bus;
      break;
    }
    $i += $multiplier;
  }
}

dump($i);
