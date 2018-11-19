<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use function assert;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\NestedArraySorter;
use Stratadox\Sorting\Contracts\DefinesHowToSort;

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
                $this->noSort(),
                $unsorted
            ],
            'Ascending by index'        => [
                $unsorted,
                $this->doSort(true),
                $ascending
            ],
            'Descending by index'       => [
                $unsorted,
                $this->doSort(false),
                $descending
            ],
        ];
    }

    /**
     * @return MockObject|DefinesHowToSort
     */
    protected function noSort(): DefinesHowToSort
    {
        $noSort = $this->createConfiguredMock(DefinesHowToSort::class, [
            'isRequired' => false
        ]);
        assert($noSort instanceof DefinesHowToSort);
        return $noSort;
    }

    /**
     * @param bool $ascending
     * @return MockObject|DefinesHowToSort
     */
    protected function doSort(bool $ascending): DefinesHowToSort
    {
        $doSort = $this->createConfiguredMock(DefinesHowToSort::class, [
            'isRequired' => true,
            'field'      => 'result.index',
            'ascends'    => $ascending,
            'next'       => $this->noSort(),
        ]);
        assert($doSort instanceof DefinesHowToSort);
        return $doSort;
    }
}
