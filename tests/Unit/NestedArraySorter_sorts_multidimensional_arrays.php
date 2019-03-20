<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DoNotSort;
use Stratadox\Sorting\NestedArraySorter;
use Stratadox\Sorting\Contracts\DefinesHowToSort;
use Stratadox\Sorting\Sort;

/**
 * @covers \Stratadox\Sorting\NestedArraySorter
 * @covers \Stratadox\Sorting\Sorter
 */
class NestedArraySorter_sorts_multidimensional_arrays extends TestCase
{
    /**
     * @param array[]          $arrays
     * @param DefinesHowToSort $usingThisDefinition
     * @param array[]          $expectedResult
     *
     * @test
     * @dataProvider sortingData
     */
    function sorting_the_arrays(
        array $arrays,
        DefinesHowToSort $usingThisDefinition,
        array $expectedResult
    ) {
        $actual = (new NestedArraySorter)->sortThe($arrays, $usingThisDefinition);
        $this->assertEquals($expectedResult, $actual);
    }

    public function sortingData(): array
    {
        $unsorted = [
            ['result' => ['index' => 3, 'label' => 'bar']],
            ['result' => ['index' => 2, 'label' => 'qux']],
            ['result' => ['index' => 1, 'label' => 'baz']],
            ['result' => ['index' => 2, 'label' => 'foo']],
        ];
        $ascending = [
            ['result' => ['index' => 1, 'label' => 'baz']],
            ['result' => ['index' => 2, 'label' => 'qux']],
            ['result' => ['index' => 2, 'label' => 'foo']],
            ['result' => ['index' => 3, 'label' => 'bar']],
        ];
        $descending = [
            ['result' => ['index' => 3, 'label' => 'bar']],
            ['result' => ['index' => 2, 'label' => 'qux']],
            ['result' => ['index' => 2, 'label' => 'foo']],
            ['result' => ['index' => 1, 'label' => 'baz']],
        ];
        return [
            'Not expecting any sorting' => [
                $unsorted,
                DoNotSort::atAll(),
                $unsorted
            ],
            'Ascending by index'        => [
                $unsorted,
                Sort::ascendingBy('result.index'),
                $ascending
            ],
            'Descending by index'       => [
                $unsorted,
                Sort::descendingBy('result.index'),
                $descending
            ],
        ];
    }
}
