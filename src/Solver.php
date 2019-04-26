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
     * @param int|float|null $itemLimit
     *
     * @throws UnexpectedValueException
     */
    public function __construct(array $items, $weightLimit, $itemLimit = null)
    {
        $this->prepareItems($items);
        $this->weightLimit = $weightLimit;
        $this->itemLimit = $itemLimit !== null ? $itemLimit : count($items);
    }

    /**
     * @return Solution
     */
    public function solve()
    {
        list($value, $itemIndexes) = $this->iterate(count($this->items) - 1, $this->weightLimit, $this->itemLimit);
        $chosenItems = $this->buildItems($itemIndexes);

        return new Solution($chosenItems, $value, $this->iterations);
    }

    private function iterate($index, $availableWeight, $availableItems)
    {
        if ($index < 0) {
            return [0, []];
        }

        // TODO this doesn't quite work as expected
        if ($availableItems === 0) {
            return [0, []];
        }

        $this->iterations++;

        if (isset($this->memo[$index][$availableWeight])) {
            return [$this->memo[$index][$availableWeight], $this->memo['picked'][$index][$availableWeight]];
        }

        // At end of decision branch
        if ($index === 0) {
            if ($this->weights[$index] <= $availableWeight) {
                // Cache this branch
                $this->memo[$index][$availableWeight] = $this->values[$index];
                $this->memo['picked'][$index][$availableWeight] = [$index];

                return [$this->values[$index], [$index]];
            }

            $this->memo[$index][$availableWeight] = 0;
            $this->memo['picked'][$index][$availableWeight] = [];

            return [0, []];
        }

        // Get the result of the next branch (without this item)
        list ($valueWithoutCurrent, $chosenItemsWithoutCurrent) = $this->iterate($index - 1, $availableWeight, $availableItems);

        // This item is too heavy for this branch
        if ($this->weights[$index] > $availableWeight) {
            // Cache and return the result without the current item
            $this->memo[$index][$availableWeight] = $valueWithoutCurrent;
            $this->memo['picked'][$index][$availableWeight] = $chosenItemsWithoutCurrent;

            return [$valueWithoutCurrent, $chosenItemsWithoutCurrent];
        }

        // Get the result of the next branch (with this item)
        $resultantAvailableWeight = $availableWeight - $this->weights[$index];
        list ($valueWithCurrent, $chosenItemsWithCurrent) = $this->iterate($index - 1, $resultantAvailableWeight, $availableItems - 1);
        $valueWithCurrent += $this->values[$index];

        // Compare the result of including the current item or not
        if ($valueWithCurrent > $valueWithoutCurrent) {
            $res = $valueWithCurrent;
            $picked = $chosenItemsWithCurrent;
            array_push($picked, $index);
        } else {
            $res = $valueWithoutCurrent;
            $picked = $chosenItemsWithoutCurrent;
        }

        // Cache and return this result
        $this->memo[$index][$availableWeight] = $res;
        $this->memo['picked'][$index][$availableWeight] = $picked;

        return [$res, $picked];
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
