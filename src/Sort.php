<?php
declare(strict_types=1);

namespace Stratadox\Sorting;

use Stratadox\Sorting\Contracts\ExtensibleSorting;
use Stratadox\Sorting\Contracts\Sorting;

/**
 * Sort according to this definition.
 *
 * Contains the field, the sorting direction and the sorting definition for
 * unresolved elements.
 *
 * @author  Stratadox
 * @package Stratadox\Sorting
 */
final class Sort implements ExtensibleSorting
{
    private $field;
    private $ascends;
    private $next;

    private function __construct(
        string $field,
        bool $ascends,
        Sorting $next
    ) {
        $this->field = $field;
        $this->ascends = $ascends;
        $this->next = $next;
    }

    public static function descendingBy(
        string $field,
        Sorting $next = null
    ): ExtensibleSorting {
        return new Sort($field, false, $next ?: DoNotSort::atAll());
    }

    public static function ascendingBy(
        string $field,
        Sorting $next = null
    ): ExtensibleSorting {
        return new Sort($field, true, $next ?: DoNotSort::atAll());
    }

    public function field(): string
    {
        return $this->field;
    }

    public function next(): Sorting
    {
        return $this->next;
    }

    public function ascends(): bool
    {
        return $this->ascends;
    }

    public function isRequired(): bool
    {
        return true;
    }

    public function andThenAscendingBy(string $field): ExtensibleSorting
    {
        // @todo this skips custom non-null Sorting definitions, fix somehow
        return new Sort(
            $this->field,
            $this->ascends,
            $this->next instanceof ExtensibleSorting ?
                $this->next->andThenAscendingBy($field) :
                Sort::ascendingBy($field)
        );
    }

    public function andThenDescendingBy(string $field): ExtensibleSorting
    {
        // @todo this skips custom non-null Sorting definitions, fix somehow
        return new Sort(
            $this->field,
            $this->ascends,
            $this->next instanceof ExtensibleSorting ?
                $this->next->andThenDescendingBy($field) :
                Sort::descendingBy($field)
        );
    }
}
