<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\EntityManager\Exception\EntityAlreadyRegistered;
use ExtendsFramework\ORM\EntityManager\Exception\EntityNotSupported;
use ExtendsFramework\ORM\Query\QueryInterface;
use ExtendsFramework\ORM\Repository\RepositoryInterface;

class EntityManager implements EntityManagerInterface
{
    /**
     * Repositories.
     *
     * @var RepositoryInterface[]
     */
    private $repositories = [];

    /**
     * Entity map.
     *
     * Holds the repository entities by identifier.
     *
     * @var EntityInterface[][]
     */
    private $entityMap = [];

    /**
     * @inheritDoc
     */
    public function findById(string $identifier, string $class): ?EntityInterface
    {
        if (isset($this->entityMap[$class][$identifier])) {
            return $this->entityMap[$class][$identifier];
        }

        $entity = $this
            ->getRepository($class)
            ->findById($identifier);

        if ($entity instanceof EntityInterface) {
            $this->entityMap[$class][$identifier] = $entity;
        }

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function findByQuery(QueryInterface $query, string $class): CollectionInterface
    {
        return $this
            ->getRepository($class)
            ->findByQuery($query);
    }

    /**
     * Add repository for entity.
     *
     * @param RepositoryInterface $repository
     * @param string              $entity
     * @return EntityManager
     * @throws EntityAlreadyRegistered When entity is already registered.
     */
    public function addRepository(RepositoryInterface $repository, string $entity): EntityManager
    {
        if (array_key_exists($entity, $this->repositories)) {
            throw new EntityAlreadyRegistered($entity);
        }

        $this->repositories[$entity] = $repository;

        return $this;
    }

    /**
     * Get repository for entity.
     *
     * @param string $entity
     * @return RepositoryInterface
     * @throws EntityNotSupported When no repository can be found for entity.
     */
    private function getRepository(string $entity): RepositoryInterface
    {
        if (!isset($this->repositories[$entity])) {
            throw new EntityNotSupported($entity);
        }

        return $this->repositories[$entity];
    }
}
