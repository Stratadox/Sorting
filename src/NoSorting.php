<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use Stratadox\Sorting\Contracts\Sorting;

/**
 * No sorting required.
 *
 * Null object, used to define that no sorting should take place.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
final class NoSorting implements Sorting
{
    private function __construct()
    {
    }

    public static function needed(): Sorting
    {
        return new NoSorting;
    }

    public function field(): string
    {
        return '';
    }

    public function next(): Sorting
    {
        return $this;
    }

    public function ascends(): bool
    {
        return false;
    }

    public function isRequired(): bool
    {
        return false;
    }
}
