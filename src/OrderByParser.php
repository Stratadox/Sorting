<?php declare(strict_types=1);

namespace Stratadox\Sorting;

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
        return sprintf(
            'ORDER BY %s %s',
            $this->sortableFields[$sorting->field()],
            $sorting->ascends() ? 'ASC' : 'DESC'
        );
    }
}
