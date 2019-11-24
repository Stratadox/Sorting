<?php declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DoNotSort;
use Stratadox\Sorting\OrderByParser;
use Stratadox\Sorting\Sort;

/**
 * @covers \Stratadox\Sorting\OrderByParser
 */
class OrderByParser_builds_partial_sql_statements extends TestCase
{
    /** @test */
    function no_order_by_statement_if_the_sorting_definition_is_empty()
    {
        $orderBy = new OrderByParser();
        $this->assertEquals('', $orderBy->parse(DoNotSort::atAll()));
    }

    /** @test */
    function building_an_order_by_name_asc_statement()
    {
        $orderBy = new OrderByParser(['name' => 'name']);
        $this->assertEquals(
            'ORDER BY name ASC',
            $orderBy->parse(Sort::ascendingBy('name'))
        );
    }

    /** @test */
    function building_an_order_by_name_desc_statement()
    {
        $orderBy = new OrderByParser(['name' => 'name']);
        $this->assertEquals(
            'ORDER BY name DESC',
            $orderBy->parse(Sort::descendingBy('name'))
        );
    }

    /** @test */
    function building_an_order_by_table_dot_foo_asc_statement()
    {
        $orderBy = new OrderByParser(['foo' => 'table.foo']);
        $this->assertEquals(
            'ORDER BY table.foo ASC',
            $orderBy->parse(Sort::ascendingBy('foo'))
        );
    }
}
