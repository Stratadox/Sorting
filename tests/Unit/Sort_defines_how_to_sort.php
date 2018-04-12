<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\Sort;

/**
 * @covers \Stratadox\Sorting\Sort
 */
class Sort_defines_how_to_sort extends TestCase
{
    /** @test */
    function sorting_can_ascend()
    {
        $sorting = Sort::ascendingBy('foo');
        $this->assertTrue($sorting->ascends());
    }

    /** @test */
    function sorting_can_descend()
    {
        $sorting = Sort::descendingBy('bar');
        $this->assertFalse($sorting->ascends());
    }

    /** @test */
    function sorting_is_required()
    {
        $sorting = Sort::descendingBy('bar');
        $this->assertTrue($sorting->isRequired());
    }

    /** @test */
    function sorting_involves_a_field()
    {
        $sorting = Sort::descendingBy('foo');
        $this->assertSame('foo', $sorting->field());
    }

    /** @test */
    function sorting_can_involve_multiple_fields()
    {
        $sorting = Sort::descendingBy('foo', Sort::ascendingBy('bar'));
        $this->assertSame('foo', $sorting->field());
        $this->assertSame('bar', $sorting->next()->field());
    }
}
