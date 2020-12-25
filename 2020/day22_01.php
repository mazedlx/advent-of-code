<?php
$input = 'Player 1:
1
10
28
29
13
11
35
7
43
8
30
25
4
5
17
32
22
39
50
46
16
26
45
38
21

Player 2:
19
40
2
12
49
23
34
47
9
14
20
24
42
37
48
44
27
6
33
18
15
3
36
41
31';

$decks = collect(explode(PHP_EOL . PHP_EOL, $input))
  ->map(function ($deck) {
    return collect(explode(PHP_EOL, $deck))
      ->skip(1)
      ->map(function ($card) {
        return (int) $card;
      })
      ->values();
  })
  ->toArray();
$player1 = $decks[0];
$player2 = $decks[1];
$cards = count($decks) * 2;
$endOfGame = false;

while (!$endOfGame) {
  if ($player1[0] > $player2[0]) {
    array_push($player1, array_shift($player1), array_shift($player2));
  } elseif ($player1[0] < $player2[0]) {
    array_push($player2, array_shift($player2), array_shift($player1));
  }
  if (count($player1) === 0 || count($player2) === 0) {
    $winner = count($player1) === 0 ? $player2 : $player1;
    $endOfGame = true;
  }
}

collect($winner)
  ->sortKeysDesc()
  ->values()
  ->map(function ($item, $key) {
    return $item * ($key + 1);
  })
  ->sum();
