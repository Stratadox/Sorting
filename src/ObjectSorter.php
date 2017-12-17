<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

use Closure;

class ObjectSorter implements SortsTheElements
{
    private $methodNameFor;

    public function __construct(array $methodNameFor = [])
    {
        $this->methodNameFor = $methodNameFor;
    }

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
            $method = $this->methodNameFor($sorting->field());
            if ($row1->$method() > $row2->$method()) {
                return $sorting->ascends() ? 1 : -1;
            }
            if ($row1->$method() < $row2->$method()) {
                return $sorting->ascends() ? -1 : 1;
            }
            $sorting = $sorting->next();
        }
        return 0;
    }

    private function methodNameFor(string $field)
    {
        return $this->methodNameFor[$field] ?? $field;
    }
}
