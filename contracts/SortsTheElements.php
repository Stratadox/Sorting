<?php

namespace Stratadox\Sorting;

/**
 * Sorts the elements of a collection.
 *
 * @author Stratadox
 * @package Stratadox\Sorting
 */
interface SortsTheElements
{
    /**
     * Sorts the elements according to a sorting definition.
     *
     * @param mixed|array      $elements            The collection of items to sort.
     * @param DefinesHowToSort $usingThisDefinition The definition of how to sort.
     * @return mixed|array                          A sorted copy of the input collection.
     */
    public function sortThe($elements, DefinesHowToSort $usingThisDefinition);
}
