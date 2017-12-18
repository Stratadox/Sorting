<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

/**
 * Defines how to sort the collection of items.
 *
 * @author Stratadox
 * @package Stratadox\Sorting
 */
interface DefinesHowToSort
{
    /**
     * Defines the field to sort by.
     *
     * @return string The field name
     */
    public function field() : string;

    /**
     * Defines whether to sort ascending or descending.
     *
     * @return bool Whether to sort ascending.
     */
    public function ascends() : bool;

    /**
     * Defines whether this sorting step should be taken.
     *
     * @return bool Whether this sorting step is required.
     */
    public function isRequired() : bool;

    /**
     * Defines how to sort unresolved candidates.
     *
     * @return DefinesHowToSort The next candidates' ordering.
     */
    public function next() : DefinesHowToSort;
}
