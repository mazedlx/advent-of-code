<?php
$min = 359282;
$max = 820401;
$valid = 0;

for ($i = $min; $i <= $max; $i++) {
    if (preg_match('/([0-9])\1/', $i)) {
        $digits = str_split($i);
        if (
            $digits[0] <= $digits[1] &&
            $digits[1] <= $digits[2] &&
            $digits[2] <= $digits[3] &&
                      $digits[3] <= $digits[4] &&
                      $digits[4] <= $digits[5]
        ) {
			$valid++;
        }
    }
}

echo $valid . PHP_EOL;