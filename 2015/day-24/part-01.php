<?php
function getPermutations($input = [], $length = 2, $delimiter = ",") {
        $permutations = [[]];
        $data = is_array($input) ? $input : explode($delimiter, $input);

        for ($count = 0; $count < $length; $count++) {
            $tmp = [];
            foreach ($permutations as $permutation) {
                foreach ($data as $inputValue)
                    $tmp[] = array_merge($permutation, [$inputValue]);

            }
            $permutations = $tmp;
        }

        return $permutations;

    }



$weights = [
    1,
    3,
    5,
    11,
    13,
    17,
    19,
    23,
    29,
    31,
    41,
    43,
    47,
    53,
    59,
    61,
    67,
    71,
    73,
    79,
    83,
    89,
    97,
    101,
    103,
    107,
    109,
    113
];


var_dump(getPermutations($weights, 5, ','));