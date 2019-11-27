<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\NoSorting;
use Stratadox\Sorting\Sorted;

/**
 * @covers \Stratadox\Sorting\NoSorting
 */
class NoSorting_when_no_sorting_is_needed extends TestCase
{
    /** @test */
    function sorting_is_not_required()
    {
        $sorting = NoSorting::needed();
        $this->assertFalse($sorting->isRequired());
    }

    /** @test */
    function sorting_is_not_required_as_array()
    {
        $sorting = Sorted::by([]);
        $this->assertFalse($sorting->isRequired());
    }

    /** @test */
    function not_sorting_has_no_field_data()
    {
        $sorting = NoSorting::needed();
        $this->assertSame('', $sorting->field());
    }

    /** @test */
    function not_sorting_does_not_ascend()
    {
        $sorting = NoSorting::needed();
        $this->assertFalse($sorting->ascends());
    }

    /** @test */
    function DoNotSort_has_no_next_sorting_step()
    {
        $sorting = NoSorting::needed();
        $this->assertFalse($sorting->next()->isRequired());
    }
}
