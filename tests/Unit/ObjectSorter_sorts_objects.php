<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Test\SortMockingTest;
use Stratadox\Sorting\Test\Unit\Stub\Thing;

/**
 * @covers \Stratadox\Sorting\ObjectSorter
 * @covers \Stratadox\Sorting\Sorter
 */
class ObjectSorter_sorts_objects extends SortMockingTest
{
    /** @scenario */
    function sorting_Things_by_foo()
    {
        $sorter = new ObjectSorter;
        $things = [
            new Thing('b', '1'),
            new Thing('c'),
            new Thing('a'),
            new Thing('b', '2'),
        ];
        $sortedThings = $sorter->sortThe($things, $this->sortBy('foo'));
        $this->assertEquals(
            [
                new Thing('a'),
                new Thing('b', '1'),
                new Thing('b', '2'),
                new Thing('c'),
            ],
            $sortedThings
        );
    }

    /** @scenario */
    function sorting_Things_by_bar_via_getBar()
    {
        $sorter = new ObjectSorter(['bar' => 'getBar']);
        $things = [
            new Thing('a', '3'),
            new Thing('b', '2'),
            new Thing('c', '1'),
            new Thing('d', '2'),
        ];
        $sortedThings = $sorter->sortThe($things, $this->sortBy('bar'));
        $this->assertEquals(
            [
                new Thing('c', '1'),
                new Thing('b', '2'),
                new Thing('d', '2'),
                new Thing('a', '3'),
            ],
            $sortedThings
        );
    }
}
