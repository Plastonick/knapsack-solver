<?php

namespace Plastonick\Knapsack;

use function array_push;

class State
{
    /** @var int|float */
    private $value;

    /** @var Item[] */
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
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
