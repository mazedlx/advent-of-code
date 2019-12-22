<?php

$instructions = [
    'jio a, +22',
    'inc a',
    'tpl a',
    'tpl a',
    'tpl a',
    'inc a',
    'tpl a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'jmp +19',
    'tpl a',
    'tpl a',
    'tpl a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'inc a',
    'tpl a',
    'inc a',
    'tpl a',
    'tpl a',
    'jio a, +8',
    'inc b',
    'jie a, +4',
    'tpl a',
    'inc a',
    'jmp +2',
    'hlf a',
    'jmp -7'
];

$registers = [
    'a' => 0,
    'b' => 0
];

for ($pos = 0; $pos < count($instructions); ) {
    if (strstr($instructions[$pos], 'inc')) {
        $r = explode(' ', $instructions[$pos])[1];
        $registers[$r] += 1;
        $pos++;
    } elseif (strstr($instructions[$pos], 'jio')) {
        $os = explode(', ', $instructions[$pos])[1];
        $r = explode(' ', explode(', ', $instructions[$pos])[0])[1];
        if ($registers[$r] === 1) {
            $pos += $os;
        } else {
            $pos++;
        }
    } elseif (strstr($instructions[$pos], 'tpl')) {
        $r = explode(' ', $instructions[$pos])[1];
        $registers[$r] *= 3;
        $pos++;
    } elseif (strstr($instructions[$pos], 'hlf')) {
        $r = explode(' ', $instructions[$pos])[1];
        $registers[$r] /= 2;
        $pos++;
    } elseif (strstr($instructions[$pos], 'jmp')) {
        $os = explode(' ', $instructions[$pos])[1];
        $pos += $os;
    } elseif (strstr($instructions[$pos], 'jie')) {
        $os = explode(', ', $instructions[$pos])[1];
        $r = explode(' ', explode(', ', $instructions[$pos])[0])[1];
        if ($registers[$r] % 2 === 0) {
            $pos += $os;
        } else {
            $pos++;
        }
    }
}

var_dump($registers);