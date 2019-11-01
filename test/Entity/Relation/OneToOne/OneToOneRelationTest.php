<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation\OneToOne;

use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\Entity\Relation\OneToOne\Exception\NullRelationNotAllowed;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class OneToOneRelationTest extends TestCase
{
    /**
     * Get related.
     *
     * Test that entity manager will be called to get a single entity for the property value. Also test that the entity
     * manager won't be called twice to get the related entity again.
     *
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::getRelated()
     */
    public function testGetRelated(): void
    {
        $related = $this->createMock(EntityInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('findById')
            ->with('3', 'AuthorEntity')
            ->willReturn($related);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('3');

        $entity = $this->createMock(EntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getProperty')
            ->with('author_id')
            ->willReturn($property);

        /**
         * @var EntityManagerInterface $entityManager
         * @var EntityInterface        $entity
         */
        $relation = new OneToOneRelation('author', 'author_id', 'AuthorEntity', true);

        $this->assertSame($related, $relation->getRelated($entityManager, $entity));
        $this->assertSame($related, $relation->getRelated($entityManager, $entity)); // Must read from cache.
    }

    /**
     * Related null value.
     *
     * Test that null will be returned when relation is nullable and related entity can not be found.
     *
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::getRelated()
     */
    public function testRelatedNullValue(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('findById')
            ->with('3', 'AuthorEntity')
            ->willReturn(null);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('3');

        $entity = $this->createMock(EntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getProperty')
            ->with('author_id')
            ->willReturn($property);

        /**
         * @var EntityManagerInterface $entityManager
         * @var EntityInterface        $entity
         */
        $relation = new OneToOneRelation('author', 'author_id', 'AuthorEntity', true);

        $this->assertNull($relation->getRelated($entityManager, $entity));
    }

    /**
     * Entity not found.
     *
     * Test that an exception will be thrown when relation is not nullable and related entity can not be found.
     *
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\OneToOneRelation::getRelated()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToOne\Exception\NullRelationNotAllowed::__construct()
     */
    public function testEntityNotFound(): void
    {
        $this->expectException(NullRelationNotAllowed::class);
        $this->expectExceptionMessage('Null value for relation "author" is not allowed.');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('findById')
            ->with('3', 'AuthorEntity')
            ->willReturn(null);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('3');

        $entity = $this->createMock(EntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getProperty')
            ->with('author_id')
            ->willReturn($property);

        /**
         * @var EntityManagerInterface $entityManager
         * @var EntityInterface        $entity
         */
        $relation = new OneToOneRelation('author', 'author_id', 'AuthorEntity', false);
        $relation->getRelated($entityManager, $entity);
    }
}
