<?php

use PHPUnit\Framework\TestCase;
use Plastonick\Knapsack\BasicItem;

final class BasicItemTest extends TestCase
{
    public function testGetters()
    {
        $name = 'name';
        $weight = 123.45;
        $value = 34;

        $item = new BasicItem($name, $weight, $value);

        $this->assertEquals($name, $item->getName());
        $this->assertEquals($weight, $item->getWeight());
        $this->assertEquals($value, $item->getValue());
    }
}
