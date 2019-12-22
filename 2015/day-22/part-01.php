<?php

$spells = [
	'Magic Missile' => [
		'cost' => 53, 
		'dmg' => 4,
		'effect' => null,
		'heals' => 0,
		'def' => 0,
	],
	'Drain' => [
		'cost' => 73, 
		'dmg' => 2, 
		'effect' => null,
		'heals' => 2,
		'def' => 0,
	],
	'Shield' => [
		'cost' => 113, 
		'dmg' => 0,
		'effect' => [
			'duration' => 6, 
			'def' => 7,
			'dmg' => 0,
			'heals' => 0,
			'mana' => 0,
		],
		'heals' => 0,
	],
	'Poison' => [
		'cost' => 173, 
		'effect' => [
			'duration' => 6, 
			'dmg' => 3,
			'def' => 0,
			'heals' => 0,
			'mana' => 0,
		],
		'heals' => 0,
		'dmg' => 0,
		'def' => 0,
	],
	'Recharge' => [
		'cost' => 229, 
		'effect' => [
			'duration' => 5, 
			'mana' => 101,
			'def' => 0,
			'dmg' => 0,
			'heals' => 0,
		],
		'dmg' => 0,
		'def' => 0,
		'heals' => 0,
	],
];

$player = [
	'hp' => 50,
	'dmg' => 0,
	'def' => 0,
	'mana' => 500,
];

$boss = [
	'hp' => 58,
	'dmg' => 9,
	'def' => 0,
];
$round = 0;

while($boss['hp'] > 0 && $player['hp'] > 0) {
	$round++;
	$spell = $spells['Drain'];	
	if ($effect = $spell['effect']) {
		if($effect['duration'] > $round) {
			$def = $effect['def'];
			$dmg = $effect['dmg'];
			$mana = $effect['mana'];
			$hp = $effect['heals'];
			
		}
	} else {
		$dmg = 0;
		$def = 0;
		$hp = 0;
	}
	echo 'Player attacks', PHP_EOL;
	$boss['hp'] -= ($spell['dmg'] + $dmg);
	echo 'Boss HP now: ', $boss['hp'], PHP_EOL;
	$player['hp'] += ($spell['heals'] + $hp);
	if ($boss['hp'] <= 0) {
		echo 'boss dead, PHP_EOL';
		break;
	}
	$player['mana'] -= $spell['cost'];
	if ($player['mana'] < 0) {
		echo 'no more mana', PHP_EOL;
		break;
	}
	echo 'Player Mana: ', $player['mana'],PHP_EOL;
	echo 'Boss attacks', PHP_EOL;
	$player['hp'] -= ($boss['dmg'] - $player['def']) >= 1 ? ($boss['dmg'] - $player['def']) : 1;
	echo 'Player HP now: ', $player['hp'], PHP_EOL;
	echo 'End of Round ' . $round, PHP_EOL;
	echo '------------------------', PHP_EOL;
	
}

echo $boss['hp'] < $player ['hp'] ? 'WIN' : 'LOSS';
