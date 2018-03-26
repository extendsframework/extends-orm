<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\EntityManager\Exception\EntityNotSupported;
use ExtendsFramework\ORM\Query\QueryInterface;

interface EntityManagerInterface
{
    /**
     * Find by identity.
     *
     * Find entity for identifier.
     *
     * @param string $identifier
     * @param string $class
     * @return EntityInterface|null
     * @throws EntityNotSupported When entity is not supported by entity manager.
     */
    public function findById(string $identifier, string $class): ?EntityInterface;

    /**
     * Find by query.
     *
     * Get a collection for query.
     *
     * @param QueryInterface $query
     * @param string         $class
     * @return CollectionInterface
     * @throws EntityNotSupported When entity is not supported by entity manager.
     */
    public function findByQuery(QueryInterface $query, string $class): CollectionInterface;
}
