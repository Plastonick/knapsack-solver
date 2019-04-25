<?php

namespace Plastonick\Knapsack;

class BasicItem implements Item
{
    private $name;

    private $weight;

    private $value;

    public function __construct($name, $weight, $value)
    {
        $this->name = $name;
        $this->weight = $weight;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getValue()
    {
        return $this->value;
    }
}
