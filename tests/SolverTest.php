<?php

use PHPUnit\Framework\TestCase;
use Plastonick\Knapsack\BasicItem;
use Plastonick\Knapsack\Item;
use Plastonick\Knapsack\Solver;

final class SolverTest extends TestCase
{
    /**
     * @dataProvider basicItemProvider
     *
     * @param Item[] $items
     * @param int|float $weightLimit
     * @param int|float $expectedValue
     * @param int|float $expectedWeight
     */
    public function testClassicKnapsackProblem($items, $weightLimit, $expectedValue, $expectedWeight)
    {
        $solver = new Solver($items, $weightLimit);
        $solution = $solver->solve();

        $this->assertEquals($expectedValue, $solution->getValue());
        $this->assertEquals($expectedWeight, $solution->getWeight());
    }

    public function basicItemProvider()
    {
        $items = $this->buildBasicItems();
        return ['basic example' => [$items, 400, 1030, 396]];
    }

    /**
     * @dataProvider itemLimitParametersProvider
     *
     * @param int $itemLimit
     * @param int|float $weightLimit
     * @param int|float $expectedValue
     * @param int|float $expectedWeight
     */
    public function testItemLimitVariant($itemLimit, $weightLimit, $expectedValue, $expectedWeight)
    {
        $items = $this->buildBasicItems();

        $solver = new Solver($items, $weightLimit, $itemLimit);
        $solution = $solver->solve();

        $this->assertEquals($expectedValue, $solution->getValue());
        $this->assertEquals($expectedWeight, $solution->getWeight());
    }

    public function itemLimitParametersProvider()
    {
        // item limit, weight limit, expected value, expected weight
        return [
            'larger limit than number of items' => [30, 400, 1030, 396],
            'no items' => [0, 400, 0, 0],
            'no items, tiny limit' => [0, 0, 0, 0],
            'many items, tiny limit' => [10, 0, 0, 0],
            'one item medium-large limit' => [1, 60, 160, 50],
            'two items medium-large limit' => [2, 60, 310, 59],
            'four items arbitrarily large limit' => [4, 999, 590, 234],
            'six items medium limit' => [6, 200, 605, 177],
        ];
    }

    /**
     * @return array
     */
    private function buildBasicItems()
    {
        $itemData = [
            'map' => [9, 150],
            'compass' => [13, 35],
            'water' => [153, 200],
            'sandwich' => [50, 160],
            'glucose' => [15, 60],
            'tin' => [68, 45],
            'banana' => [27, 60],
            'apple' => [39, 40],
            'cheese' => [23, 30],
            'beer' => [52, 10],
            'suntan cream' => [11, 70],
            'camera' => [32, 30],
            't-shirt' => [24, 15],
            'trousers' => [48, 10],
            'umbrella' => [73, 40],
            'waterproof trousers' => [42, 70],
            'waterproof overclothes' => [43, 75],
            'note-case' => [22, 80],
            'sunglasses' => [7, 20],
            'towel' => [18, 12],
            'socks' => [4, 50],
            'book' => [30, 10],
        ];

        $items = [];
        foreach ($itemData as $name => list($weight, $value)) {
            $items[] = new BasicItem($name, $weight, $value);
        }

        return $items;
    }
}
