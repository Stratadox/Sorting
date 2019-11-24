<?php declare(strict_types=1);

namespace Stratadox\Sorting;

use function array_key_exists;
use InvalidArgumentException;
use function sprintf;
use Stratadox\Sorting\Contracts\Sorting;

class OrderByParser
{
    /** @var array */
    private $sortableFields;

    public function __construct(array $sortableFields = [])
    {
        $this->sortableFields = $sortableFields;
    }

    public function parse(Sorting $sorting): string
    {
        if (!$sorting->isRequired()) {
            return '';
        }
        if (!array_key_exists($sorting->field(), $this->sortableFields)) {
            throw new InvalidArgumentException(
                $sorting->field() . ' is not a sortable field.'
            );
        }
        return sprintf(
            'ORDER BY %s %s',
            $this->sortableFields[$sorting->field()],
            $sorting->ascends() ? 'ASC' : 'DESC'
        );
    }
}
