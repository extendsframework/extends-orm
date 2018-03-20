<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Entity\Exception\PropertyNotFound;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;

interface RelationInterface
{
    /**
     * Get relation name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get related.
     *
     * Related can be an single entity or a collection.
     *
     * @param EntityManagerInterface $entityManager
     * @param EntityInterface        $entity
     * @return EntityInterface|CollectionInterface|null
     * @throws PropertyNotFound When entity property can not be found.
     */
    public function getRelated(EntityManagerInterface $entityManager, EntityInterface $entity);
}
