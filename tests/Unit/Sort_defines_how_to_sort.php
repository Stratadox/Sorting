<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DefinesHowToSort;
use Stratadox\Sorting\Sort;

/**
 * @covers \Stratadox\Sorting\Sort
 */
class Sort_defines_how_to_sort extends TestCase
{
    /** @scenario */
    function sorting_can_ascend()
    {
        $sorting = Sort::ascendingBy('foo');
        $this->assertTrue($sorting->ascends());
    }

    /** @scenario */
    function sorting_can_descend()
    {
        $sorting = Sort::descendingBy('bar');
        $this->assertFalse($sorting->ascends());
    }

    /** @scenario */
    function sorting_is_required()
    {
        $sorting = Sort::descendingBy('bar');
        $this->assertTrue($sorting->isRequired());
    }

    /** @scenario */
    function sorting_involves_a_field()
    {
        $sorting = Sort::descendingBy('foo');
        $this->assertSame('foo', $sorting->field());
    }

    /** @scenario */
    function sorting_can_involve_multiple_fields()
    {
        $sorting = Sort::descendingBy('foo', Sort::ascendingBy('bar'));
        $this->assertInstanceOf(DefinesHowToSort::class, $sorting->next());
    }
}