<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use Closure;
use Stratadox\Sorting\Contracts\Sorter;
use Stratadox\Sorting\Contracts\Sorting;

/**
 * Sorter logic for comparing multiple values according to the sort definition.
 *
 * Leaves retrieving the values to the concrete implementations.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
abstract class ElementSorter implements Sorter
{
    public function sort(array $elements, Sorting $sorting): array
    {
        usort($elements, $this->functionFor($sorting));
        return $elements;
    }

    private function functionFor(Sorting $sorting): Closure
    {
        return function ($element1, $element2) use ($sorting) {
            return $this->doTheSorting($element1, $element2, $sorting);
        };
    }

    private function doTheSorting(
        $element1,
        $element2,
        Sorting $sorting
    ): int {
        $comparison = 0;
        while ($sorting->isRequired()) {
            $comparison = $this->compareElements(
                $element1,
                $element2,
                $sorting
            );
            if ($comparison !== 0) {
                break;
            }
            $sorting = $sorting->next();
        }
        return $comparison;
    }

    private function compareElements(
        $element1,
        $element2,
        Sorting $sorting
    ): int {
        if ($sorting->ascends()) {
            return $this->compareValues(
                $this->valueFor($element1, $sorting->field()),
                $this->valueFor($element2, $sorting->field())
            );
        }
        return $this->compareValues(
            $this->valueFor($element2, $sorting->field()),
            $this->valueFor($element1, $sorting->field())
        );
    }

    private function compareValues($value1, $value2): int
    {
        return $value1 <=> $value2;
    }

    abstract protected function valueFor($element, string $field);
}
