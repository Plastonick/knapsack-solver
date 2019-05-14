<?php

use PHPUnit\Framework\TestCase;
use Plastonick\Knapsack\BasicItem;
use Plastonick\Knapsack\State;

final class StateTest extends TestCase
{
    /**
     * @dataProvider basicItemProvider
     *
     * @param BasicItem[] $items
     * @param int|float $value
     */
    public function testGetters(array $items, $value)
    {
        $state = new State($value, $items);

        $this->assertEquals($items, $state->getItems());
        $this->assertEquals($value, $state->getValue());
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

        return ['basic example' => [$items, 13]];
    }
}
