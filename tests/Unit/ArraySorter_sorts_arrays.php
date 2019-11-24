<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Contracts\Sorting;
use Stratadox\Sorting\DoNotSort;
use Stratadox\Sorting\Sort;

/**
 * @covers \Stratadox\Sorting\ArraySorter
 * @covers \Stratadox\Sorting\ElementSorter
 */
class ArraySorter_sorts_arrays extends TestCase
{
    /**
     * @param array[] $arrays
     * @param Sorting $usingThisDefinition
     * @param array[] $expectedResult
     *
     * @test
     * @dataProvider sortingData
     */
    function sorting_the_arrays(
        array $arrays,
        Sorting $usingThisDefinition,
        array $expectedResult
    ) {
        $actual = (new ArraySorter)->sortThe($arrays, $usingThisDefinition);
        $this->assertEquals($expectedResult, $actual);
    }

    public function sortingData(): array
    {
        $unsorted = [
            ['index' => 3, 'label' => 'bar'],
            ['index' => 2, 'label' => 'qux'],
            ['index' => 1, 'label' => 'baz'],
            ['index' => 2, 'label' => 'foo'],
        ];
        $ascending = [
            ['index' => 1, 'label' => 'baz'],
            ['index' => 2, 'label' => 'qux'],
            ['index' => 2, 'label' => 'foo'],
            ['index' => 3, 'label' => 'bar'],
        ];
        $descending = [
            ['index' => 3, 'label' => 'bar'],
            ['index' => 2, 'label' => 'qux'],
            ['index' => 2, 'label' => 'foo'],
            ['index' => 1, 'label' => 'baz'],
        ];
        return [
            'Not expecting any sorting' => [
                $unsorted,
                DoNotSort::atAll(),
                $unsorted
            ],
            'Ascending by index'        => [
                $unsorted,
                Sort::ascendingBy('index'),
                $ascending
            ],
            'Descending by index'       => [
                $unsorted,
                Sort::descendingBy('index'),
                $descending
            ],
        ];
    }
}
