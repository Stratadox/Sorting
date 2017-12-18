# Sorting

[![Build Status](https://travis-ci.org/Stratadox/Sorting.svg?branch=master)](https://travis-ci.org/Stratadox/Sorting)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/Sorting/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/Sorting?branch=master)

The sorting package contains tools to sort data structures like tables or collections of objects.

## Installation

Install using composer:
`composer require stratadox/sorting`

## Basic usage

### 2D Arrays

```php
<?php

$table = [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Baz', 'rating' => 2],
];
$sorter = new ArraySorter;
$table = $sorter->sortThe($table, Sort::descendingBy('rating'));
```

### Objects
```php
<?php

$objects = [
    new SomeObject('Foo', 3),
    new SomeObject('Bar', 1),
    new SomeObject('Baz', 2),
];
$sorter = new ObjectSorter;
$objects = $sorter->sortThe($objects, Sort::descendingBy('rating'));
```

## Sorting by multiple fields

```php
<?php

$table = [
    ['name' => 'Foo', 'rating' => 3],
    ['name' => 'Bar', 'rating' => 1],
    ['name' => 'Baz', 'rating' => 1],
];
$sorter = new ArraySorter;
$table = $sorter->sortThe($table, 
    Sort::descendingBy('rating', Sort::descendingBy('name'))
);
```

