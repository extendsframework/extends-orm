<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity;

use ExtendsFramework\ORM\Entity\Exception\EntityAlreadyInitialized;
use ExtendsFramework\ORM\Entity\Exception\EntityIsImmutable;
use ExtendsFramework\ORM\Entity\Exception\PropertyNotFound;
use ExtendsFramework\ORM\Entity\Exception\RelationNotFound;
use ExtendsFramework\ORM\Entity\Property\PropertyException;
use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\Entity\Relation\RelationInterface;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Raw data.
     *
     * @var object
     */
    private $data;

    /**
     * Entity properties.
     *
     * @var PropertyInterface[]
     */
    private $properties = [];

    /**
     * Entity relations.
     *
     * @var RelationInterface[]
     */
    private $relations = [];

    /**
     * If entity is initialized.
     *
     * @var bool
     */
    private $initialized = false;

    /**
     * @inheritDoc
     * @throws PropertyNotFound When property for relation can not be found.
     */
    public function __get(string $name)
    {
        if (isset($this->relations[$name]) === true) {
            return $this->relations[$name]->getRelated($this->entityManager, $this);
        }

        if (isset($this->properties[$name]) === true) {
            return $this->properties[$name]->getValue();
        }

        return null;
    }

    /**
     * @inheritDoc
     * @throws EntityIsImmutable When trying to set a property, entity is immutable and can not be changed.
     */
    public function __set(string $name, $value): void
    {
        throw new EntityIsImmutable($name);
    }

    /**
     * @inheritDoc
     */
    public function __isset(string $name): bool
    {
        return isset($this->properties[$name]) || isset($this->relations[$name]);
    }

    /**
     * @inheritDoc
     */
    public function initialize(EntityManagerInterface $entityManager, object $data): EntityInterface
    {
        if ($this->initialized === true) {
            throw new EntityAlreadyInitialized();
        }

        $this->entityManager = $entityManager;
        $this->data = $data;
        $this->initialized = true;

        return $this
            ->setUp()
            ->populate($data);
    }

    /**
     * @inheritDoc
     */
    public function getProperty(string $name): PropertyInterface
    {
        if (isset($this->properties[$name]) === false) {
            throw new PropertyNotFound($name);
        }

        return $this->properties[$name];
    }

    /**
     * @inheritDoc
     */
    public function getRelation(string $name): RelationInterface
    {
        if (isset($this->relations[$name]) === false) {
            throw new RelationNotFound($name);
        }

        return $this->relations[$name];
    }

    /**
     * Add property.
     *
     * @param PropertyInterface $property
     * @return AbstractEntity
     */
    protected function addProperty(PropertyInterface $property): AbstractEntity
    {
        $this->properties[$property->getName()] = $property;

        return $this;
    }

    /**
     * Add relation.
     *
     * @param RelationInterface $relation
     * @return AbstractEntity
     */
    protected function addRelation(RelationInterface $relation): AbstractEntity
    {
        $this->relations[$relation->getName()] = $relation;

        return $this;
    }

    /**
     * Set up.
     *
     * Set up properties and relations for entity.
     *
     * @return AbstractEntity
     */
    abstract protected function setUp(): AbstractEntity;

    /**
     * Populate entity.
     *
     * @param object $data
     * @return AbstractEntity
     * @throws PropertyException
     */
    private function populate(object $data): AbstractEntity
    {
        foreach ($this->properties as $property) {
            $property->populate(
                $data->{$property->getName()} ?? null
            );
        }

        return $this;
    }
}
