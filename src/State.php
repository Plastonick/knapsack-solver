<?php

namespace Plastonick\Knapsack;

class State
{
    /** @var int|float */
    private $value;

    /** @var array */
    private $items;

    public function __construct($value, array $items)
    {
        $this->value = $value;
        $this->items = $items;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
