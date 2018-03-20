<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Repository;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Query\QueryInterface;

interface RepositoryInterface
{
    /**
     * Find entity by identifier.
     *
     * @param string $identifier
     * @return EntityInterface|null
     */
    public function findById(string $identifier): ?EntityInterface;

    /**
     * Find entity collection for query.
     *
     * @param QueryInterface $query
     * @return CollectionInterface
     */
    public function findByQuery(QueryInterface $query): CollectionInterface;
}
