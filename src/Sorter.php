<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use Closure;
use Stratadox\Sorting\Contracts\DefinesHowToSort;
use Stratadox\Sorting\Contracts\SortsTheElements;

/**
 * Sorter logic for comparing multiple values according to the sort definition.
 *
 * Leaves retrieving the values to the concrete implementations.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
abstract class Sorter implements SortsTheElements
{
    public function sortThe($elements, DefinesHowToSort $sorting): array
    {
        usort($elements, $this->function($sorting));
        return $elements;
    }

    private function function (DefinesHowToSort $sorting): Closure
    {
        return function ($element1, $element2) use ($sorting) {
            return $this->doTheSorting($element1, $element2, $sorting);
        };
    }

    private function doTheSorting(
        $element1,
        $element2,
        DefinesHowToSort $sorting
    ): int {
        $comparison = 0;
        while ($sorting->isRequired()) {
            $comparison = $this->compareElements($element1, $element2, $sorting);
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
        DefinesHowToSort $sorting
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
