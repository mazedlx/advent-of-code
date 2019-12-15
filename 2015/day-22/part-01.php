<?php

$weapons = [
    'Dagger' => ['cost' => 8, 'damage' => 4, 'armor' => 0],
    'Shortsword' => ['cost' => 10, 'damage' => 5, 'armor' => 0],
    'Warhammer' => ['cost' => 25, 'damage' => 6, 'armor' => 0],
    'Longsword' => ['cost' => 40, 'damage' => 7, 'armor' => 0],
    'Greataxe' => ['cost' => 74, 'damage' => 8, 'armor' => 0]
];
$armors = [
    'None' => ['cost' => 0, 'damage' => 0, 'armor' => 0],
    'Leather' => ['cost' => 13, 'damage' => 0, 'armor' => 1],
    'Chainmail' => ['cost' => 31, 'damage' => 0, 'armor' => 2],
    'Splintmail' => ['cost' => 53, 'damage' => 0, 'armor' => 3],
    'Bandedmail' => ['cost' => 75, 'damage' => 0, 'armor' => 4],
    'Platemail' => ['cost' => 102, 'damage' => 0, 'armor' => 5]
];
$rings = [
    'None' => ['cost' => 0, 'damage' => 0, 'armor' => 0],
    'Damage +1' => ['cost' => 25, 'damage' => 1, 'armor' => 0],
    'Damage +2' => ['cost' => 50, 'damage' => 2, 'armor' => 0],
    'Damage +3' => ['cost' => 100, 'damage' => 3, 'armor' => 0],
    'Defense +1' => ['cost' => 20, 'damage' => 0, 'armor' => 1],
    'Defense +2' => ['cost' => 40, 'damage' => 0, 'armor' => 2],
    'Defense +3' => ['cost' => 80, 'damage' => 0, 'armor' => 3]
];
$rings2 = [
    'None' => ['cost' => 0, 'damage' => 0, 'armor' => 0],
    'Damage +1' => ['cost' => 25, 'damage' => 1, 'armor' => 0],
    'Damage +2' => ['cost' => 50, 'damage' => 2, 'armor' => 0],
    'Damage +3' => ['cost' => 100, 'damage' => 3, 'armor' => 0],
    'Defense +1' => ['cost' => 20, 'damage' => 0, 'armor' => 1],
    'Defense +2' => ['cost' => 40, 'damage' => 0, 'armor' => 2],
    'Defense +3' => ['cost' => 80, 'damage' => 0, 'armor' => 3]
];
$wins = [];
foreach ($weapons as $nameOfWeapon => $weapon) {
    foreach ($armors as $nameOfArmor => $armor) {
        foreach ($rings as $nameOfRing => $ring) {
            foreach ($rings2 as $nameOfRing2 => $ring2) {
                if (
                    $ring['cost'] === 0 || $ring['cost'] != $ring2['cost']
                ) {
                    $attack =
                        $weapon['damage'] +
                        $armor['damage'] +
                        $ring['damage'] +
                        $ring2['damage'];

                    $defense =
                        $weapon['armor'] +
                        $armor['armor'] +
                        $ring['armor'] +
                        $ring2['armor'];

                    $gold =
                        $weapon['cost'] +
                        $armor['cost'] +
                        $ring['cost'] +
                        $ring2['cost'];

                    $player = [
                        'hp' => 100,
                        'damage' => $attack,
                        'armor' => $defense,
                        'gold' => $gold
                    ];

                    $boss = [
                        'hp' => 103,
                        'damage' => 9,
                        'armor' => 2
                    ];

                    while ($boss['hp'] > 0 && $player['hp'] > 0) {
                        $boss['hp'] -= ($player['damage'] - $boss['armor'])	;
                        if ($boss['hp'] <= 0) {
                        	break;
                        }
                        $player['hp'] -= ($boss['damage'] - $player['armor']);
                    }
                    if ($boss['hp'] < $player['hp']) {
                        $wins[] = $gold;
                    } 
                }
            }
        }
    }
}

sort($wins);
echo $wins[0], PHP_EOL;
