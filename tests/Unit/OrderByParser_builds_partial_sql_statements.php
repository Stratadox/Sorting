<?php declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DoNotSort;
use Stratadox\Sorting\OrderByParser;

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
}
