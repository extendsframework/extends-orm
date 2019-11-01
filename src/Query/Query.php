<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;

class Query implements QueryInterface
{
    /**
     * @var CriterionInterface|null
     */
    private $criteria;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * Query constructor.
     *
     * @param CriterionInterface|null $criteria
     * @param int|null                $limit
     * @param int|null                $offset
     */
    public function __construct(
        CriterionInterface $criteria = null,
        int $limit = null,
        int $offset = null
    ) {
        $this->criteria = $criteria;
        $this->limit = $limit ?? 20;
        $this->offset = $offset ?? 0;
    }

    /**
     * @inheritDoc
     */
    public function getCriteria(): ?CriterionInterface
    {
        return $this->criteria;
    }

    /**
     * @inheritDoc
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @inheritDoc
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
