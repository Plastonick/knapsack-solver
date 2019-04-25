<?php

namespace Plastonick\Knapsack;

interface Item
{
    public function getWeight();

    public function getValue();
}
