<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\Sort;
use Stratadox\Sorting\DefinesHowToSort;

/**
 * @covers \Stratadox\Sorting\Sort
 */
class Sort_tables_based_on_one_or_more_keys extends TestCase
{
    /** @scenario */
    function sort_ascending_by_the_index_key()
    {
        $table = [
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 0, 'value' => 'zero'],
        ];
        $sorted = $this->sortThe($table, Sort::ascendingBy('index'));
        $this->assertSame([
            ['index' => 0, 'value' => 'zero'],
            ['index' => 1, 'value' => 'one'],
            ['index' => 2, 'value' => 'two'],
            ['index' => 4, 'value' => 'four'],
        ], $sorted);
    }


    /** @scenario */
    function sort_descending_by_rating_and_then_ascending_by_name()
    {
        $table = [
            ['rating' => 2, 'name' => 'Foo'],
            ['rating' => 4, 'name' => 'Baz'],
            ['rating' => 2, 'name' => 'Quz'],
            ['rating' => 1, 'name' => 'Qux'],
            ['rating' => 2, 'name' => 'Bar'],
        ];
        $sorted = $this->sortThe($table,
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

    private function sortThe(array $table, DefinesHowToSort $sorting) : array
    {
        usort($table, function (array $row1, array $row2) use ($sorting) {
            while ($sorting) {
                if ($row1[$sorting->field()] > $row2[$sorting->field()]) {
                    return $sorting->ascends() ? 1 : -1;
                }
                if ($row1[$sorting->field()] < $row2[$sorting->field()]) {
                    return $sorting->ascends() ? -1 : 1;
                }
                $sorting = $sorting->next();
            }
            return 0;
        });
        return $table;
    }
}
