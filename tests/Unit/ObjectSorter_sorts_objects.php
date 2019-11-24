<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Sort;
use Stratadox\Sorting\Test\Stub\Thing;

/**
 * @covers \Stratadox\Sorting\ObjectSorter
 * @covers \Stratadox\Sorting\ElementSorter
 */
class ObjectSorter_sorts_objects extends TestCase
{
    /** @test */
    function sorting_Things_by_foo()
    {
        $sorter = new ObjectSorter;
        $things = [
            new Thing('b', '1'),
            new Thing('c'),
            new Thing('a'),
            new Thing('b', '2'),
        ];
        $sortedThings = $sorter->sort($things, Sort::ascendingBy('foo'));
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

    /** @test */
    function sorting_Things_by_bar_via_getBar()
    {
        $sorter = new ObjectSorter(['bar' => 'getBar']);
        $things = [
            new Thing('a', '3'),
            new Thing('b', '2'),
            new Thing('c', '1'),
            new Thing('d', '2'),
        ];
        $sortedThings = $sorter->sort($things, Sort::ascendingBy('bar'));
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
