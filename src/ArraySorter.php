<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

class ArraySorter implements SortsTheElements
{
    public function sortThe($elements, DefinesHowToSort $sorting) : array
    {
        usort($elements, function (array $row1, array $row2) use ($sorting) {
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
        });
        return $elements;
    }
}
