# Sorting

[![Build Status](https://travis-ci.org/Stratadox/Sorting.svg?branch=master)](https://travis-ci.org/Stratadox/Sorting)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/Sorting/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/Sorting?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stratadox/Sorting/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Stratadox/Sorting/?branch=master)

The sorting package contains tools to sort data structures like tables or collections of objects.

Sorting instructions are objects and can therefore easily be passed along as parameters. 
Multiple instructions can be chained in order to sort by several fields.

## Installation

Install using composer:

`composer require stratadox/sorting`

## Basic usage

### 2D Arrays
When sorting a collection of associative arrays, use:
```php
<?php
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Sort;

$table = [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Baz', 'rating' => 2],
];
$sorter = new ArraySorter();

$table = $sorter->sortThe($table, Sort::descendingBy('rating'));

assert($table === [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 2],
    ['name' => 'Bar', 'rating' => 1],
]);
```

### Objects
In case the collection consists of objects, the sorting definition remain the 
same. Instead of using the ArraySorter, the ObjectSorter picks up the sorting 
requirements.
```php
<?php
use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Sort;

class SomeObject
{
    private $name;
    private $rating;

    public function __construct(string $name, int $rating)
    {
        $this->name = $name;
        $this->rating = $rating;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rating(): int
    {
        return $this->rating;
    }
}

$objects = [
    new SomeObject('Foo', 3),
    new SomeObject('Bar', 1),
    new SomeObject('Baz', 2),
];
$sorter = new ObjectSorter();

$objects = $sorter->sortThe($objects, Sort::ascendingBy('rating'));

assert($objects == [
    new SomeObject('Bar', 1),
    new SomeObject('Baz', 2),
    new SomeObject('Foo', 3),
]);
```

#### Method mapping
When the names of the methods do not correspond to the fields, or when a custom 
method is to be used for determining the sorting weight, a mapping can be given 
to the ObjectSorter:
```php
<?php
use Stratadox\Sorting\ObjectSorter;
use Stratadox\Sorting\Sort;

class SomeObject
{
    private $name;
    private $rating;

    public function __construct(string $name, int $rating)
    {
        $this->name = $name;
        $this->rating = $rating;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTheRating(): int
    {
        return $this->rating;
    }
}

$objects = [
    new SomeObject('Foo', 3),
    new SomeObject('Bar', 1),
    new SomeObject('Baz', 2),
];
$sorter = new ObjectSorter([
    'name' => 'getName',
    'rating' => 'getTheRating',
]);

$objects = $sorter->sortThe($objects, Sort::ascendingBy('rating'));

assert($objects == [
    new SomeObject('Bar', 1),
    new SomeObject('Baz', 2),
    new SomeObject('Foo', 3),
]);
```

### Nested arrays
If the structure to be sorted consists of a list of nested arrays, one can use 
the NestedArraySorter:
```php
<?php
use Stratadox\Sorting\NestedArraySorter;
use Stratadox\Sorting\Sort;

$unsorted = [
    ['result' => ['index' => 3, 'label' => 'bar']],
    ['result' => ['index' => 2, 'label' => 'qux']],
    ['result' => ['index' => 1, 'label' => 'baz']],
    ['result' => ['index' => 2, 'label' => 'foo']],
];
$sorter = new NestedArraySorter();
$result = $sorter->sortThe($unsorted, Sort::ascendingBy('result.index'));

assert($result === [
   ['result' => ['index' => 1, 'label' => 'baz']],
   ['result' => ['index' => 2, 'label' => 'qux']],
   ['result' => ['index' => 2, 'label' => 'foo']],
   ['result' => ['index' => 3, 'label' => 'bar']],
]);
```

### Sorting by multiple fields

```php
<?php
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Sort;

$table = [
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
];
$sorter = new ArraySorter();
$table = $sorter->sortThe($table, 
    Sort::descendingBy('rating', Sort::descendingBy('name'))
);

assert($table == [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
    ['name' => 'Bar', 'rating' => 1],
]);
```

Or:

```php
<?php
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Sort;


$table = [
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
];
$sorter = new ArraySorter();
$table = $sorter->sortThe($table, 
    Sort::descendingBy('rating')->andThenDescendingBy('name')
);

assert($table == [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
    ['name' => 'Bar', 'rating' => 1],
]);
```

Or:

```php
<?php
use Stratadox\Sorting\ArraySorter;
use Stratadox\Sorting\Sorted;


$table = [
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
];
$sorter = new ArraySorter();
$table = $sorter->sortThe($table, Sorted::by([
    'rating' => false,
    'name' => false,
]));

assert($table == [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Baz', 'rating' => 1],
    ['name' => 'Bar', 'rating' => 1],
]);
```
