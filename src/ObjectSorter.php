<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

/**
 * Sorts a collection of objects, accessing fields through public methods.
 *
 * The object sorter accepts an optional map to translate fields to method names.
 *
 * @author  Stratadox
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
        return $element->{$this->methodNameFor($field)}();
    }

    private function methodNameFor(string $field): string
    {
        return $this->methodNameFor[$field] ?? $field;
    }
}
