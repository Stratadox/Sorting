<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Integration;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Sort;
use Stratadox\Sorting\SortsTheElements;
use Stratadox\Sorting\Test\Stub\Thing;

/**
 * @coversNothing because integration
 */
class Sorting_arrays_of_Things extends TestCase
{
    /** @var SortsTheElements */
    private $sorter;

    /** @test */
    function sort_ascending_by_foo()
    {
        $table = [
            new Thing('2', 'two'),
            new Thing('4', 'four'),
            new Thing('1', 'one'),
            new Thing('0', 'zero'),
        ];
        $sorted = $this->sorter->sortThe($table, Sort::ascendingBy('foo'));
        $this->assertEquals([
            new Thing('0', 'zero'),
            new Thing('1', 'one'),
            new Thing('2', 'two'),
            new Thing('4', 'four'),
        ], $sorted);
    }

    /** @test */
    function sort_descending_by_foo_and_then_ascending_by_bar()
    {
        $table = [
            new Thing('2', 'Foo'),
            new Thing('4', 'Baz'),
            new Thing('2', 'Quz'),
            new Thing('1', 'Qux'),
            new Thing('2', 'Bar'),
        ];
        $sorted = $this->sorter->sortThe($table,
            Sort::descendingBy('foo', Sort::ascendingBy('bar'))
        );
        $this->assertEquals([
            new Thing('4', 'Baz'),
            new Thing('2', 'Bar'),
            new Thing('2', 'Foo'),
            new Thing('2', 'Quz'),
            new Thing('1', 'Qux'),
        ], $sorted);
    }

    /** @test */
    function sorting_leaves_undecided_entries_in_their_original_order()
    {
        $table = [
            new Thing('2', 'two'),
            new Thing('4', 'four'),
            new Thing('1', 'one'),
            new Thing('0', 'zero'),
            new Thing('1', 'another one'),
        ];
        $sorted = $this->sorter->sortThe($table, Sort::ascendingBy('foo'));
        $this->assertEquals([
            new Thing('0', 'zero'),
            new Thing('1', 'one'),
            new Thing('1', 'another one'),
            new Thing('2', 'two'),
            new Thing('4', 'four'),
        ], $sorted);
    }

    protected function setUp()
    {
        $this->sorter = new ObjectSorter(['bar' => 'getBar']);
    }
}
