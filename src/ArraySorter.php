<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

use Closure;

class ArraySorter implements SortsTheElements
{
    public function sortThe($elements, DefinesHowToSort $sorting) : array
    {
        usort($elements, $this->function($sorting));
        return $elements;
    }

    private function function(DefinesHowToSort $sorting) : Closure
    {
        return function($row1, $row2) use ($sorting) {
            return $this->doTheSorting($row1, $row2, $sorting);
        };
    }

    private function doTheSorting(
        $row1,
        $row2,
        DefinesHowToSort $sorting
    ) : int
    {
        while ($sorting->isRequired()) {
            if ($row1[$sorting->field()] > $row2[$sorting->field()]) {
                return $sorting->ascends() ? 1 : -1;
            }
            if ($row1[$sorting->field()] < $row2[$sorting->field()]) {
                return $sorting->ascends() ? -1 : 1;
            }
            $sorting = $sorting->next();
        }
        return 0;
    }
}
