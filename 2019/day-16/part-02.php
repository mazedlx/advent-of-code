<?php

$input = '59767332893712499303507927392492799842280949032647447943708128134759829623432979665638627748828769901459920331809324277257783559980682773005090812015194705678044494427656694450683470894204458322512685463108677297931475224644120088044241514984501801055776621459006306355191173838028818541852472766531691447716699929369254367590657434009446852446382913299030985023252085192396763168288943696868044543275244584834495762182333696287306000879305760028716584659188511036134905935090284404044065551054821920696749822628998776535580685208350672371545812292776910208462128008216282210434666822690603370151291219895209312686939242854295497457769408869210686246';

for($i = 0; $i < 10000; $i++) {
    $input.= $input;
}
$input = substr($input, 5976733);
$digits = array_values(
    array_map(function ($digit) {
        return (int) $digit;
    }, str_split($input))
);

$phase = [0, 1, 0, -1];
$phases = [];
for ($pos = 0; $pos < strlen($input) + 1; $pos++) {
    $phases[$pos] = [];
    for ($j = 0; $j < strlen($input); $j++) {
        foreach ($phase as $value) {
            for ($i = 0; $i < $pos; $i++) {
                $phases[$pos][] = $value;
            }
        }
        if (count($phases[$pos]) > strlen($input) + 1) {
            break;
        }
    }
    $shift = $phases[$pos];
    array_shift($shift);
    $phases[$pos] = $shift;
}

$sum = [];

for ($i = 0; $i < 100; $i++) {
    for ($pos = 1; $pos <= strlen($input); $pos++) {
        $sum[$pos] = [];
        $phase = $phases[$pos];
        foreach ($digits as $key => $digit) {
            $i > 0 ? $key -= 1 : null;
            $sum[$pos][] = $digit * $phase[$key];
        }
        $total = array_reduce(
            $sum[$pos],
            function ($carry, $item) {
                return $carry + $item;
            },
            0
        );
        $sum[$pos] = (int) substr($total, -1, 1);
        $index = 0;
    }
    $digits = $sum;
}

echo substr(implode('', $digits), 0, 8), PHP_EOL;