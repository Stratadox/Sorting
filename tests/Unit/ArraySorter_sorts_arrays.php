<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\DefinesHowToSort;

/**
 * @covers \Stratadox\Sorting\ArraySorter
 */
class ArraySorter_sorts_arrays extends TestCase
{
    /**
     * @scenario
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
        $sorted = [
            ['index' => 1, 'label' => 'baz'],
            ['index' => 2, 'label' => 'qux'],
            ['index' => 2, 'label' => 'foo'],
            ['index' => 3, 'label' => 'bar'],
        ];
        return [
            'Not expecting any sorting' => [
                $unsorted,
                $this->noSort(),
                $unsorted
            ],
            'Sorting by index' => [
                $unsorted,
                $this->sortByIndex(),
                $sorted
            ],
        ];
    }

    /**
     * @return MockObject|DefinesHowToSort
     */
    private function noSort() : DefinesHowToSort
    {
        $noSort = $this->createMock(DefinesHowToSort::class);
        $this->mocked($noSort->expects($this->atLeastOnce()), 'isRequired', false);
        return $noSort;
    }

    /**
     * @return MockObject|DefinesHowToSort
     */
    private function sortByIndex() : DefinesHowToSort
    {
        $sort = $this->createMock(DefinesHowToSort::class);
        $this->mocked($sort->expects($this->atLeastOnce()), 'isRequired', true);
        $this->mocked($sort->expects($this->atLeastOnce()), 'field', 'index');
        $this->mocked($sort->expects($this->atLeastOnce()), 'ascends', true);
        $this->mocked($sort->expects($this->atLeastOnce()), 'next', $this->noSort());
        return $sort;
    }

    private function mocked(InvocationMocker $mocker, string $name, $returnValue) : void
    {
        $mocker->method($name);
        $mocker->willReturn($returnValue);
    }
}
