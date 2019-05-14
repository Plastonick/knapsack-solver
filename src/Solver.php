<?php

namespace Plastonick\Knapsack;

class Solver
{
    /** @var Item[] */
    private $items;

    /** @var int|float */
    private $weightLimit;

    /** @var int */
    private $itemLimit;

    /**
     * Values of items
     *
     * @var int[]|float[]
     */
    private $values = [];

    /**
     * Weights of items
     *
     * @var int[]|float[]
     */
    private $weights = [];

    /**
     * Memoization cache array
     *
     * @var array
     */
    private $memo = [];

    /** @var int */
    private $iterations = 0;

    /**
     * @param Item[] $items
     * @param int|float $weightLimit
     * @param int|float $itemLimit
     *
     * @throws UnexpectedValueException
     */
    public function __construct(array $items, $weightLimit, $itemLimit = INF)
    {
        $this->prepareItems($items);
        $this->weightLimit = $weightLimit;
        $this->itemLimit = $itemLimit;
    }

    /**
     * @return Solution
     */
    public function solve()
    {
        $state = $this->iterate(count($this->items) - 1, $this->weightLimit, $this->itemLimit);
        $chosenItems = $this->buildItems($state->getItems());

        return new Solution($chosenItems, $state->getValue(), $this->iterations);
    }

    private function iterate($index, $availableWeight, $availableItems)
    {
        $this->iterations++;
        $key = "{$index}-{$availableWeight}-{$availableItems}";

        if (isset($this->memo[$key])) {
            return $this->memo[$key];
        }

        // If we are in an invalid state, return nil values
        if ($availableItems === 0 || $index < 0 || $availableWeight < 0) {
            return new State(0, []);
        }

        // Get the result of the next branch (without this item)
        $stateWithoutCurrent = $this->iterate($index - 1, $availableWeight, $availableItems);

        // Get the result of the next branch (with this item)
        $resultantAvailableWeight = $availableWeight - $this->weights[$index];
        $stateWithCurrent = $this->iterate($index - 1, $resultantAvailableWeight, $availableItems - 1);

        // Compare the result of including the current item or not
        $valueWithCurrent = $stateWithCurrent->getValue() + $this->values[$index];
        if ($valueWithCurrent > $stateWithoutCurrent->getValue()) {
            $picked = $stateWithCurrent->getItems();
            array_push($picked, $index);

            $best = new State($valueWithCurrent, $picked);
        } else {
            $best = $stateWithoutCurrent;
        }

        // Cache and return this result
        $this->memo[$key] = $best;

        return $best;
    }

    /**
     * @param Item[] $items
     *
     * @throws UnexpectedValueException
     */
    private function prepareItems(array $items)
    {
        $this->items = $items;

        foreach ($this->items as $item) {
            if (!$item instanceof Item) {
                throw new UnexpectedValueException('Incorrect item type given');
            }

            $this->values[] = $item->getValue();
            $this->weights[] = $item->getWeight();
        }
    }

    /**
     * @param array $itemIndexes
     *
     * @return array
     */
    private function buildItems(array $itemIndexes)
    {
        $chosenItems = [];
        foreach ($itemIndexes as $index) {
            $chosenItems[] = $this->items[$index];
        }

        return $chosenItems;
    }
}
