<?php

declare(strict_types=1);

namespace Stratadox\Sorting\Test\Stub;

class Thing
{
    private $foo;
    private $bar;

    public function __construct(string $foo, string $bar = '')
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public function foo() : string
    {
        return $this->foo;
    }

    public function getBar() : string
    {
        return $this->bar;
    }
}
