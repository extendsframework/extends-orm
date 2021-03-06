<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\Exception\EntityAlreadyInitialized;
use ExtendsFramework\ORM\Entity\Exception\EntityIsImmutable;
use ExtendsFramework\ORM\Entity\Exception\IdentifierNotSet;
use ExtendsFramework\ORM\Entity\Exception\PropertyNotFound;
use ExtendsFramework\ORM\Entity\Exception\RelationNotFound;
use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\Entity\Relation\RelationInterface;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class AbstractEntityTest extends TestCase
{
    /**
     * Initialize.
     *
     * Test that entity property will be initialized with given object value.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::initialize()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::addProperty()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::addRelation()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getProperty()
     */
    public function testInitialize(): void
    {
        $relation = $this->createMock(RelationInterface::class);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('name');

        $property
            ->expects($this->once())
            ->method('populate')
            ->with('John Doe');

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $data = new stdClass();
        $data->name = 'John Doe';

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->initialize($entityManager, $data);
    }

    /**
     * Initialize.
     *
     * Test that get methods will return proper values.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::addProperty()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::addRelation()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getProperty()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getProperty()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getRelation()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getIdentifier()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::__get()
     */
    public function testGetMethods(): void
    {
        $relation = $this->createMock(RelationInterface::class);
        $relation
            ->expects($this->once())
            ->method('getName')
            ->willReturn('comments');

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('name');

        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('John Doe');

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->initialize($entityManager, new stdClass());

        $this->assertSame($property, $entity->getProperty('name'));
        $this->assertSame($relation, $entity->getRelation('comments'));
        $this->assertSame('John Doe', $entity->getIdentifier());
    }

    /**
     * Initialize.
     *
     * Test that magic get method will return correct property and relation.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::__get()
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::__isset()
     */
    public function testMagicMethods(): void
    {
        $collection = $this->createMock(CollectionInterface::class);

        $relation = $this->createMock(RelationInterface::class);
        $relation
            ->expects($this->once())
            ->method('getName')
            ->willReturn('comments');

        $relation
            ->expects($this->once())
            ->method('getRelated')
            ->willReturn($collection);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('name');

        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('John Doe');

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->initialize($entityManager, new stdClass());

        $this->assertSame('John Doe', $entity->name);
        $this->assertSame($collection, $entity->comments);
        $this->assertNull($entity->unknown);

        $this->assertTrue(isset($entity->name));
        $this->assertTrue(isset($entity->comments));
        $this->assertFalse(isset($entity->unknown));
    }

    /**
     * Entity is immutable.
     *
     * Test that entity is immutable and property can not be set.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::__set()
     * @covers \ExtendsFramework\ORM\Entity\Exception\EntityIsImmutable::__construct()
     */
    public function testEntityIsImmutable(): void
    {
        $this->expectException(EntityIsImmutable::class);
        $this->expectExceptionMessage('Entity is immutable and property "name" can not be set.');

        $relation = $this->createMock(RelationInterface::class);

        $property = $this->createMock(PropertyInterface::class);

        /**
         * @var PropertyInterface $property
         * @var RelationInterface $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->name = 'John Doe';
    }

    /**
     * Identifier not set.
     *
     * Test that and exception will be thrown when identifier is not set after set up.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::initialize()
     * @covers \ExtendsFramework\ORM\Entity\Exception\IdentifierNotSet::__construct()
     */
    public function testIdentifierNotSet(): void
    {
        $this->expectException(IdentifierNotSet::class);
        $this->expectExceptionMessage('No identifier set for entity.');

        $entity = new class extends AbstractEntity
        {
            /**
             * @inheritDoc
             */
            protected function setUp(): void
            {
            }
        };

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         */
        $entity->initialize($entityManager, new stdClass());
    }

    /**
     * Entity already initialized.
     *
     * Test that an exception will be thrown when entity is already initialized.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::initialize()
     * @covers \ExtendsFramework\ORM\Entity\Exception\EntityAlreadyInitialized::__construct()
     */
    public function testEntityAlreadyInitialized(): void
    {
        $this->expectException(EntityAlreadyInitialized::class);
        $this->expectExceptionMessage('Entity can only be initialized once.');

        $relation = $this->createMock(RelationInterface::class);

        $property = $this->createMock(PropertyInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity
            ->initialize($entityManager, new stdClass())
            ->initialize($entityManager, new stdClass());
    }

    /**
     * Property not found.
     *
     * Test that an exception will be thrown when property can not be found.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getProperty()
     * @covers \ExtendsFramework\ORM\Entity\Exception\PropertyNotFound::__construct()
     */
    public function testPropertyNotFound(): void
    {
        $this->expectException(PropertyNotFound::class);
        $this->expectExceptionMessage('Property with name "name" can not be found.');

        $relation = $this->createMock(RelationInterface::class);

        $property = $this->createMock(PropertyInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->initialize($entityManager, new stdClass());

        $entity->getProperty('name');
    }

    /**
     * Relation not found.
     *
     * Test that an exception will be thrown when relation can not be found.
     *
     * @covers \ExtendsFramework\ORM\Entity\AbstractEntity::getRelation()
     * @covers \ExtendsFramework\ORM\Entity\Exception\RelationNotFound::__construct()
     */
    public function testRelationNotFound(): void
    {
        $this->expectException(RelationNotFound::class);
        $this->expectExceptionMessage('Relation with name "command" can not be found.');

        $relation = $this->createMock(RelationInterface::class);

        $property = $this->createMock(PropertyInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        /**
         * @var EntityManagerInterface $entityManager
         * @var PropertyInterface      $property
         * @var RelationInterface      $relation
         */
        $entity = new EntityStub($property, $relation);
        $entity->initialize($entityManager, new stdClass());

        $entity->getRelation('command');
    }
}
