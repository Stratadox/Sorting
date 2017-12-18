<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

use function call_user_func;

/**
 * Sorts a collection of objects, accessing fields through public methods.
 *
 * The object sorter accepts a map of fields that do not directly correspond to
 * method names.
 *
 * @author Stratadox
 * @package Stratadox\Sorting
 */
class ObjectSorter extends Sorter
{
    private $methodNameFor;

    public function __construct(array $methodNames = [])
    {
        $this->methodNameFor = $methodNames;
    }

    protected function valueFor($element, string $field)
    {
        return call_user_func([$element, $this->methodNameFor($field)]);
    }

    private function methodNameFor(string $field)
    {
        return $this->methodNameFor[$field] ?? $field;
    }
}
