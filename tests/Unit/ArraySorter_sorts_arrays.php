<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\DefinesHowToSort;

/**
 * @covers \Stratadox\Sorting\ArraySorter
 * @covers \Stratadox\Sorting\Sorter
 */
class ArraySorter_sorts_arrays extends TestCase
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
        $actual = (new ArraySorter)->sortThe($arrays, $usingThisDefinition);
        $this->assertEquals($expectedResult, $actual);
    }

    public function sortingData() : array
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
                $this->noSort(),
                $unsorted
            ],
            'Ascending by index' => [
                $unsorted,
                $this->doSort(true),
                $ascending
            ],
            'Descending by index' => [
                $unsorted,
                $this->doSort(false),
                $descending
            ],
        ];
    }

    /**
     * @return MockObject|DefinesHowToSort
     */
    protected function noSort() : DefinesHowToSort
    {
        return $this->createConfiguredMock(DefinesHowToSort::class, [
            'isRequired' => false
        ]);
    }

    /**
     * @param bool $ascending
     * @return MockObject|DefinesHowToSort
     */
    protected function doSort(bool $ascending) : DefinesHowToSort
    {
        return $this->createConfiguredMock(DefinesHowToSort::class, [
            'isRequired' => true,
            'field' => 'index',
            'ascends' => $ascending,
            'next' => $this->noSort(),
        ]);
    }
}
