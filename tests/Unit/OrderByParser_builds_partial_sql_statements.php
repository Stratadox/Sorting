<?php declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use InvalidArgumentException;
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
        $orderBy = OrderByParser::mappedAs([]);
        $this->assertEquals('', $orderBy->parse(DoNotSort::atAll()));
    }

    /** @test */
    function building_an_order_by_name_asc_statement()
    {
        $orderBy = OrderByParser::allowing('name');
        $this->assertEquals(
            'ORDER BY name ASC',
            $orderBy->parse(Sort::ascendingBy('name'))
        );
    }

    /** @test */
    function building_an_order_by_name_desc_statement()
    {
        $orderBy = OrderByParser::allowing('name');
        $this->assertEquals(
            'ORDER BY name DESC',
            $orderBy->parse(Sort::descendingBy('name'))
        );
    }

    /** @test */
    function building_an_order_by_table_dot_foo_asc_statement()
    {
        $orderBy = OrderByParser::mappedAs(['foo' => 'table.foo']);
        $this->assertEquals(
            'ORDER BY table.foo ASC',
            $orderBy->parse(Sort::ascendingBy('foo'))
        );
    }

    /** @test */
    function not_building_order_by_statements_for_non_whitelisted_fields()
    {
        $orderBy = OrderByParser::allowing('name');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('foo is not a sortable field');

        $orderBy->parse(Sort::ascendingBy('foo'));
    }

    /** @test */
    function ordering_by_foo_desc_and_bar_asc()
    {
        $orderBy = OrderByParser::mappedAs(['foo' => 'x.foo', 'bar' => 'y.bar']);
        $this->assertEquals(
            'ORDER BY x.foo DESC, y.bar ASC',
            $orderBy->parse(Sort::descendingBy('foo')->andThenAscendingBy('bar'))
        );
    }

    /** @test */
    function ordering_by_foo_asc_and_bar_asc()
    {
        $orderBy = OrderByParser::mappedAs(['foo' => 'x.foo', 'bar' => 'y.bar']);
        $this->assertEquals(
            'ORDER BY x.foo ASC, y.bar ASC',
            $orderBy->parse(Sort::ascendingBy('foo')->andThenAscendingBy('bar'))
        );
    }

    /** @test */
    function ordering_by_foo_asc_and_bar_desc_and_baz_asc()
    {
        $orderBy = OrderByParser::mappedAs([
            'foo' => 'x.foo',
            'bar' => 'y.bar',
            'baz' => 'z.baz',
        ]);
        $this->assertEquals(
            'ORDER BY x.foo ASC, y.bar DESC, z.baz ASC',
            $orderBy->parse(
                Sort::ascendingBy('foo')
                    ->andThenDescendingBy('bar')
                    ->andThenAscendingBy('baz')
            )
        );
    }
}
