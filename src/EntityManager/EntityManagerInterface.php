<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\EntityManager\Exception\EntityNotFound;
use ExtendsFramework\ORM\Query\QueryInterface;

interface EntityManagerInterface
{
    /**
     * Find by identity.
     *
     * Find entity for identifier.
     *
     * @param string $identifier
     * @param string $entity
     * @return EntityInterface
     * @throws EntityNotFound When entity can not be found for identifier.
     */
    public function findById(string $identifier, string $entity): EntityInterface;

    /**
     * Find by query.
     *
     * Get a collection for query.
     *
     * @param QueryInterface $query
     * @param string         $entity
     * @return CollectionInterface
     */
    public function findByQuery(QueryInterface $query, string $entity): CollectionInterface;
}
