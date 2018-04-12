<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

/**
 * Sorts a collection of arrays.
 *
 * Objects that implement ArrayAccess are considered arrays for this purpose.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
class ArraySorter extends Sorter
{
    protected function valueFor($element, string $field)
    {
        return $element[$field];
    }
}
