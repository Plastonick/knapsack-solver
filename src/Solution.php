<?php

namespace Plastonick\Knapsack;

class Solution
{
    /** @var Item[] */
    private $items;

    /** @var int|float */
    private $value;

    /** @var int */
    private $iterations;

    /**
     * @param Item[] $items
     * @param int|float $value
     * @param int $iterations
     */
    public function __construct(array $items, $value, $iterations)
    {
        $this->items = $items;
        $this->value = $value;
        $this->iterations = $iterations;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int|float
     */
    public function getWeight()
    {
        return array_reduce(
            $this->items,
            function ($comparison, Item $item) {
                return $comparison + $item->getWeight();
            }
        );
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }
}
