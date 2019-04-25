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
