<?php

$masses = [
    70904,
    66770,
    118678,
    58460,
    128566,
    60820,
    107153,
    113196,
    52413,
    118335,
    96711,
    88120,
    129744,
    64049,
    90586,
    54466,
    55693,
    102407,
    148273,
    110281,
    111814,
    60951,
    102879,
    135253,
    130081,
    86645,
    72934,
    147097,
    74578,
    124073,
    100003,
    103314,
    86468,
    84557,
    94232,
    120012,
    64372,
    143081,
    96664,
    148076,
    147357,
    139897,
    113139,
    143022,
    144298,
    81293,
    53679,
    139311,
    107156,
    121730,
    132519,
    132666,
    80464,
    111118,
    76734,
    139023,
    111287,
    126811,
    130539,
    129173,
    67549,
    102058,
    72673,
    91194,
    64753,
    59488,
    126300,
    94407,
    126813,
    60028,
    95129,
    79270,
    123465,
    60966,
    111920,
    76549,
    110195,
    119975,
    112557,
    129676,
    104941,
    89583,
    121895,
    108901,
    135247,
    75129,
    148646,
    131128,
    78931,
    111637,
    72752,
    140761,
    57387,
    85684,
    77596,
    134159,
    63031,
    148361,
    133856,
    82022,
];

function calcFuel($mass)
{
    $fuel = floor($mass / 3) - 2;
    $total = $fuel;
    if($fuel > 5) {
        $total += calcFuel($fuel);
    }
    return $total;
}

$total = 0;

foreach ($masses as $mass) {
    $total+= calcFuel($mass, 0);
}

echo $total . PHP_EOL;