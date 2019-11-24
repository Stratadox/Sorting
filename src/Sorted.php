<?php declare(strict_types=1);

namespace Stratadox\Sorting;

use Stratadox\Sorting\Contracts\Sorting;

final class Sorted
{
    public static function by(array $fields): Sorting
    {
        /** @var Sort|null $sorting */
        $sorting = null;
        foreach ($fields as $field => $ascend) {
            if ($sorting === null) {
                $sorting = $ascend ?
                    Sort::ascendingBy($field) :
                    Sort::descendingBy($field);
            } else {
                $sorting = $ascend ?
                    $sorting->andThenAscendingBy($field) :
                    $sorting->andThenDescendingBy($field);
            }
        }
        return $sorting ?: DoNotSort::atAll();
    }
}
