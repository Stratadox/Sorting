<?php

declare(strict_types=1);

namespace Stratadox\Sorting;

interface DefinesHowToSort
{
    public function field() : string;
    public function next() : DefinesHowToSort;
    public function ascends() : bool;
    public function isRequired() : bool;
}
