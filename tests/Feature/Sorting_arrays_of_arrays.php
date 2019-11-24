<?php
declare(strict_types=1);

namespace Stratadox\Sorting\Test\Feature;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Contracts\Sorter;
use Stratadox\Sorting\Sort;

class Sorting_arrays_of_arrays extends TestCase
{
    /** @var Sorter */
    private $sorter;

    /** @test */
    function sort_ascending_by_the_index_key()
    {
        $table = [
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 0, 'value' => 'zero'],
        ];
        $sorted = $this->sorter->sortThe($table, Sort::ascendingBy('index'));
        $this->assertSame([
            ['index' => 0, 'value' => 'zero'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
        ], $sorted);
    }

    /** @test */
    function sort_descending_by_rating_and_then_ascending_by_name()
    {
        $table = [
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Bar'],
        ];
        $sorted = $this->sorter->sortThe($table,
            Sort::descendingBy('rating', Sort::ascendingBy('name'))
        );
        $this->assertSame([
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Bar'],
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
        ], $sorted);
    }

    /** @test */
    function sort_descending_by_rating_and_then_ascending_by_name_as_method()
    {
        $table = [
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Bar'],
        ];
        $sorted = $this->sorter->sortThe($table,
            Sort::descendingBy('rating')->andThenAscendingBy('name')
        );
        $this->assertSame([
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Bar'],
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
        ], $sorted);
    }

    /** @test */
    function sort_ascending_by_rating_and_then_descending_by_name()
    {
        $table = [
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Bar'],
        ];
        $sorted = $this->sorter->sortThe($table,
            Sort::ascendingBy('rating', Sort::descendingBy('name'))
        );
        $this->assertSame([
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 2, 'name' => 'Bar'],
            ['rating' => 4, 'name' => 'Baz'],
        ], $sorted);
    }

    /** @test */
    function sort_ascending_by_rating_and_then_descending_by_name_as_method()
    {
        $table = [
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Bar'],
        ];
        $sorted = $this->sorter->sortThe($table,
            Sort::ascendingBy('rating')->andThenDescendingBy('name')
        );
        $this->assertSame([
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 2, 'name' => 'Bar'],
            ['rating' => 4, 'name' => 'Baz'],
        ], $sorted);
    }

    /** @test */
    function sorting_leaves_undecided_entries_in_their_original_order()
    {
        $table = [
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 0, 'value' => 'zero'],
            ['index' => 1, 'value' => 'another one'],
        ];
        $sorted = $this->sorter->sortThe($table, Sort::ascendingBy('index'));
        $this->assertSame([
            ['index' => 0, 'value' => 'zero'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 1, 'value' => 'another one'],
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
        ], $sorted);
    }

    protected function setUp()
    {
        $this->sorter = new ArraySorter;
    }
}
