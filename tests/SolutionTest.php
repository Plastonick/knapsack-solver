<?php

use PHPUnit\Framework\TestCase;
use Plastonick\Knapsack\BasicItem;
use Plastonick\Knapsack\Item;
use Plastonick\Knapsack\Solution;

final class SolutionTest extends TestCase
{
    /**
     * @dataProvider basicItemProvider
     *
     * @param Item[] $items
     * @param int $iterations
     * @param int|float $expectedValue
     * @param int|float $expectedWeight
     */
    public function testSolution($items, $iterations, $expectedValue, $expectedWeight)
    {
        $solution = new Solution($items, $expectedValue, $iterations);

        $this->assertEquals($items, $solution->getItems());
        $this->assertEquals($iterations, $solution->getIterations());
        $this->assertEquals($expectedValue, $solution->getValue());
        $this->assertEquals($expectedWeight, $solution->getWeight());
    }

    public function basicItemProvider()
    {
        $itemData = [
            [1, 2],
            [4, 3],
            [3, 1],
            [4, 3],
            [1, 1],
        ];

        $items = [];
        foreach ($itemData as list($value, $weight)) {
            $items[] = new BasicItem('name', $weight, $value);
        }

        return ['basic example' => [$items, 123, 13, 10]];
    }
}
