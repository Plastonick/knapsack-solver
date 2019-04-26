<?php

use Plastonick\Knapsack\BasicItem;
use Plastonick\Knapsack\Solver;

require_once 'vendor/autoload.php';

// see https://rosettacode.org/wiki/Knapsack_problem/0-1 for the description of the problem

$names = [
    'map',
    'compass',
    'water',
    'sandwich',
    'glucose',
    'tin',
    'banana',
    'apple',
    'cheese',
    'beer',
    'suntan cream',
    'camera',
    't-shirt',
    'trousers',
    'umbrella',
    'waterproof trousers',
    'waterproof overclothes',
    'note-case',
    'sunglasses',
    'towel',
    'socks',
    'book',
];
$weights = [9, 13, 153, 50, 15, 68, 27, 39, 23, 52, 11, 32, 24, 48, 73, 42, 43, 22, 7, 18, 4, 30];
$values = [150, 35, 200, 160, 60, 45, 60, 40, 30, 10, 70, 30, 15, 10, 40, 70, 75, 80, 20, 12, 50, 10];

$items = [];
foreach ($names as $index => $name) {
  $items[] = new BasicItem($name, $weights[$index], $values[$index]);
}

$solver = new Solver($items, 400, 4);
$solution = $solver->solve();

echo "Total value: {$solution->getValue()}\n";
echo "Computed in: {$solution->getIterations()} iterations\n\n";

/** @var BasicItem $item */
foreach ($solution->getItems() as $item) {
    echo "Picked item: {$item->getName()}\n";
}
