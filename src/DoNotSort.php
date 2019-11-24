<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use Stratadox\Sorting\Contracts\Sorting;

/**
 * Do not sort at all.
 *
 * Null object, used to define that no sorting should take place.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
final class DoNotSort implements Sorting
{
    private function __construct()
    {
    }

    public static function atAll(): Sorting
    {
        return new DoNotSort;
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
