<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\Contracts\DefinesHowToSort;
use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Test\Stub\Thing;

/**
 * @covers \Stratadox\Sorting\ObjectSorter
 * @covers \Stratadox\Sorting\Sorter
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

    /**
     * @param string $field
     * @return MockObject|DefinesHowToSort
     */
    protected function sortBy(string $field) : DefinesHowToSort
    {
        return $this->createConfiguredMock(DefinesHowToSort::class, [
            'isRequired' => true,
            'field' => $field,
            'ascends' => true,
            'next' => $this->createConfiguredMock(DefinesHowToSort::class, [
                'isRequired' => false
            ]),
        ]);
    }
}
