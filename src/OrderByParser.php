<?php declare(strict_types=1);

namespace Stratadox\Sorting;

use function array_combine;
use function array_key_exists;
use function implode;
use InvalidArgumentException;
use function sprintf;
use Stratadox\Sorting\Contracts\Sorting;

class OrderByParser
{
    /** @var array */
    private $sortableFields;

    private function __construct(array $sortableFields = [])
    {
        $this->sortableFields = $sortableFields;
    }

    public static function mappedAs(array $sortableFieldsMap): self
    {
        return new self($sortableFieldsMap);
    }

    public static function allowing(string ...$sortableFields): self
    {
        return new self(array_combine($sortableFields, $sortableFields));
    }

    public function parse(Sorting $sorting): string
    {
        if (!$sorting->isRequired()) {
            return '';
        }
        $orderBy = [];
        while ($sorting->isRequired()) {
            $orderBy[] = $this->parseSingle($sorting);
            $sorting = $sorting->next();
        }
        return sprintf('ORDER BY %s', implode(', ', $orderBy));
    }

    private function parseSingle(Sorting $sorting): string
    {
        if (!array_key_exists($sorting->field(), $this->sortableFields)) {
            throw new InvalidArgumentException(
                $sorting->field() . ' is not a sortable field.'
            );
        }
        return sprintf(
            '%s %s',
            $this->sortableFields[$sorting->field()],
            $sorting->ascends() ? 'ASC' : 'DESC'
        );
    }
}
