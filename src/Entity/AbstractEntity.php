<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity;

use ExtendsFramework\ORM\Entity\Exception\EntityAlreadyInitialized;
use ExtendsFramework\ORM\Entity\Exception\EntityIsImmutable;
use ExtendsFramework\ORM\Entity\Exception\IdentifierNotSet;
use ExtendsFramework\ORM\Entity\Exception\PropertyNotFound;
use ExtendsFramework\ORM\Entity\Exception\RelationNotFound;
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
     * Entity identity property.
     *
     * @var PropertyInterface|null
     */
    private $identifier;

    /**
     * @inheritDoc
     * @throws PropertyNotFound When property for relation can not be found.
     */
    public function __get(string $name)
    {
        if (isset($this->relations[$name])) {
            return $this->relations[$name]->getRelated($this->entityManager, $this);
        }

        if (isset($this->properties[$name])) {
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
    public function getIdentifier(): string
    {
        return $this->identifier->getValue();
    }

    /**
     * @inheritDoc
     */
    public function initialize(EntityManagerInterface $entityManager, object $data): EntityInterface
    {
        if ($this->initialized) {
            throw new EntityAlreadyInitialized();
        }

        $this->entityManager = $entityManager;
        $this->data = $data;
        $this->initialized = true;

        $this->setUp();
        if ($this->identifier === null) {
            throw new IdentifierNotSet();
        }

        foreach ($this->properties as $property) {
            $property->populate($data->{$property->getName()} ?? null);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProperty(string $name): PropertyInterface
    {
        if (!isset($this->properties[$name])) {
            throw new PropertyNotFound($name);
        }

        return $this->properties[$name];
    }

    /**
     * @inheritDoc
     */
    public function getRelation(string $name): RelationInterface
    {
        if (!isset($this->relations[$name])) {
            throw new RelationNotFound($name);
        }

        return $this->relations[$name];
    }

    /**
     * Add property.
     *
     * @param PropertyInterface $property   Property to add.
     * @param bool|null         $identifier If this property identifies the entity.
     * @return AbstractEntity
     */
    protected function addProperty(PropertyInterface $property, bool $identifier = null): AbstractEntity
    {
        if ($identifier) {
            $this->identifier = $property;
        }

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
     * @return void
     */
    abstract protected function setUp(): void;
}
