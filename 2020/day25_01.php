<?php
$subject = 7;
$key1 = 11349501;
$key2 = 5107328;

$searchValue = 1;
$result = 1;
while (true) {
  $result = ($result * $key2) % 20201227;
  $searchValue = ($searchValue * $subject) % 20201227;
  if ($searchValue === $key1) {
    dd($result);
  }
}
