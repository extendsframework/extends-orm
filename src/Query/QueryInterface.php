<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;

interface QueryInterface
{
    /**
     * Get criteria.
     *
     * @return CriterionInterface|null
     */
    public function getCriteria(): ?CriterionInterface;

    /**
     * Get limit.
     *
     * @return int
     */
    public function getLimit(): int;

    /**
     * Get offset.
     *
     * @return int
     */
    public function getOffset(): int;
}
