<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

use function call_user_func;

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
