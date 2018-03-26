<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity;

use ExtendsFramework\ORM\Entity\Exception\EntityAlreadyInitialized;
use ExtendsFramework\ORM\Entity\Exception\IdentifierNotSet;
use ExtendsFramework\ORM\Entity\Exception\PropertyNotFound;
use ExtendsFramework\ORM\Entity\Exception\RelationNotFound;
use ExtendsFramework\ORM\Entity\Property\PropertyException;
use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\Entity\Relation\RelationInterface;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;

interface EntityInterface
{
    /**
     * Get entity identifier.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Get property.
     *
     * @param string $name
     * @return PropertyInterface
     * @throws PropertyNotFound When property for name can not be found.
     */
    public function getProperty(string $name): PropertyInterface;

    /**
     * Get relation.
     *
     * @param string $name
     * @return RelationInterface
     * @throws RelationNotFound When relation for name can not be found.
     */
    public function getRelation(string $name): RelationInterface;

    /**
     * Initialize.
     *
     * Set the entity manager and populate entity with data.
     *
     * @param EntityManagerInterface $entityManager
     * @param object                 $data
     * @return EntityInterface
     * @throws EntityAlreadyInitialized When entity is already initialized.
     * @throws IdentifierNotSet         When identifier is not set for entity.
     * @throws PropertyException        When property failed to populate property value.
     */
    public function initialize(EntityManagerInterface $entityManager, object $data): EntityInterface;
}
