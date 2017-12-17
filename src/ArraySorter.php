<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

class ArraySorter extends Sorter
{
    protected function valueFor($element, string $field)
    {
        return $element[$field];
    }
}
