<?php
$timestamp = 1000186;
$input =
  '17,x,x,x,x,x,x,x,x,x,x,37,x,x,x,x,x,907,x,x,x,x,x,x,x,x,x,x,x,19,x,x,x,x,x,x,x,x,x,x,23,x,x,x,x,x,29,x,653,x,x,x,x,x,x,x,x,x,41,x,x,13';

$buses = collect(explode(',', $input))
  ->filter(function ($bus) {
    return $bus !== 'x';
  })
  ->values()
  ->sort()
  ->mapWithKeys(function ($bus) {
    return [(int) $bus => (int) $bus];
  })
  ->map(function ($bus) use ($timestamp) {
    return $bus * floor($timestamp / $bus);
  })
  ->map(function ($time, $bus) use ($timestamp) {
    return $time - $timestamp + $bus;
  })
  ->sort()
  ->take(1)
  ->map(function ($bus, $key) {
    return $bus * $key;
  })
  ->first();
