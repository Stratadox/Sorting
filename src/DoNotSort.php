<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

final class DoNotSort implements DefinesHowToSort
{
    public static function atAll() : DefinesHowToSort
    {
        return new DoNotSort;
    }

    public function field() : string
    {
        return '';
    }

    public function next() : DefinesHowToSort
    {
        return $this;
    }

    public function ascends() : bool
    {
        return false;
    }

    public function isRequired() : bool
    {
        return false;
    }
}
