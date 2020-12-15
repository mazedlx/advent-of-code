<?php
$input = '0,14,1,3,7,9';
$target = 30000000;
$numbers = collect(explode(',', $input))->map(function ($number) {
  return (int) $number;
});

$last = $numbers->pop();
$memory = $numbers->combine(range(1, $numbers->count()))->toArray();
$turn = $numbers->count() + 1;
while ($turn++ < $target) {
  if (!isset($memory[$last])) {
    $memory[$last] = $turn - 1;
    $last = 0;
  } else {
    $prev = $memory[$last];
    $memory[$last] = $turn - 1;
    $last = $turn - 1 - $prev;
  }
}

dump($last);
