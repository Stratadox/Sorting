<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

final class Sort implements DefinesHowToSort
{
    private $field;
    private $ascends;
    private $next;

    private function __construct(
        string $field,
        bool $ascends,
        DefinesHowToSort $next = null
    ) {
        $this->field = $field;
        $this->ascends = $ascends;
        $this->next = $next;
    }

    public static function descendingBy(
        string $field,
        DefinesHowToSort $next = null
    ) : DefinesHowToSort
    {
        return new Sort($field, false, $next);
    }

    public static function ascendingBy(
        string $field,
        DefinesHowToSort $next = null
    ) : DefinesHowToSort
    {
        return new Sort($field, true, $next);
    }

    public function field() : string
    {
        return $this->field;
    }

    public function next() : DefinesHowToSort
    {
        return $this->next;
    }

    public function ascends() : bool
    {
        return $this->ascends;
    }

    public function isRequired() : bool
    {
        return true;
    }
}
