<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test;

use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DefinesHowToSort;

abstract class SortMockingTest extends TestCase
{
    /**
     * @return MockObject|DefinesHowToSort
     */
    protected function noSort() : DefinesHowToSort
    {
        $noSort = $this->createMock(DefinesHowToSort::class);
        $this->mocked($noSort->expects($this->atLeastOnce()), 'isRequired', false);
        return $noSort;
    }

    /**
     * @param string $field
     * @return MockObject|DefinesHowToSort
     */
    protected function sortBy(string $field) : DefinesHowToSort
    {
        $sort = $this->createMock(DefinesHowToSort::class);
        $this->mocked($sort->expects($this->atLeastOnce()), 'isRequired', true);
        $this->mocked($sort->expects($this->atLeastOnce()), 'field', $field);
        $this->mocked($sort->expects($this->atLeastOnce()), 'ascends', true);
        $this->mocked($sort->expects($this->atLeastOnce()), 'next', $this->noSort());
        return $sort;
    }

    protected function mocked(InvocationMocker $mocker, string $name, $returnValue) : void
    {
        $mocker->method($name);
        $mocker->willReturn($returnValue);
    }
}
