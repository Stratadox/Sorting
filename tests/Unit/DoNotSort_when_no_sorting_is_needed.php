<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\Sorting\DoNotSort;

/**
 * @covers \Stratadox\Sorting\DoNotSort
 */
class DoNotSort_when_no_sorting_is_needed extends TestCase
{
    /** @test */
    function sorting_is_not_required()
    {
        $sorting = DoNotSort::atAll();
        $this->assertFalse($sorting->isRequired());
    }

    /** @test */
    function not_sorting_has_no_field_data()
    {
        $sorting = DoNotSort::atAll();
        $this->assertSame('', $sorting->field());
    }

    /** @test */
    function not_sorting_does_not_ascend()
    {
        $sorting = DoNotSort::atAll();
        $this->assertFalse($sorting->ascends());
    }

    /** @test */
    function DoNotSort_has_no_next_sorting_step()
    {
        $sorting = DoNotSort::atAll();
        $this->assertInstanceOf(DoNotSort::class, $sorting->next());
    }
}
