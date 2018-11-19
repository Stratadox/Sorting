<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use function explode;

/**
 * Sorts a collection of multi-dimensional arrays.
 *
 * Objects that implement ArrayAccess are considered arrays for this purpose.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
class NestedArraySorter extends Sorter
{
    protected function valueFor($element, string $field)
    {
        foreach (explode('.', $field) as $offset) {
            $element = $element[$offset];
        }
        return $element;
    }
}
