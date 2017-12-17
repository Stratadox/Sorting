<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

use Closure;

abstract class Sorter implements SortsTheElements
{
    public function sortThe($elements, DefinesHowToSort $sorting) : array
    {
        usort($elements, $this->function($sorting));
        return $elements;
    }

    private function function(DefinesHowToSort $sorting) : Closure
    {
        return function($element1, $element2) use ($sorting) {
            return $this->doTheSorting($element1, $element2, $sorting);
        };
    }

    private function doTheSorting(
        $element1,
        $element2,
        DefinesHowToSort $sorting
    ) : int
    {
        while ($sorting->isRequired()) {
            $value1 = $this->valueFor($element1, $sorting->field());
            $value2 = $this->valueFor($element2, $sorting->field());
            if ($value1 > $value2) {
                return $sorting->ascends() ? 1 : -1;
            }
            if ($value1 < $value2) {
                return $sorting->ascends() ? -1 : 1;
            }
            $sorting = $sorting->next();
        }
        return 0;
    }

    abstract protected function valueFor($element, string $field);
}