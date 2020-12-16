<?php
$row = 2978;
$col = 3083;
$code = 20151125;

$previousDiagonals = $row + $col - 2;
$nth = ($previousDiagonals * ($previousDiagonals + 1)) / 2 + $col;

for ($i = 1; $i < $nth; $i++) {
  $code = ($code * 252533) % 33554393;
}

dd($code);
