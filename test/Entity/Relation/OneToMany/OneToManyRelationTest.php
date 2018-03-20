<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation\OneToMany;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class OneToManyRelationTest extends TestCase
{
    /**
     * Get related.
     *
     * Test that entity manager will be called to get a entity collection for the property value. Also test that the
     * entity manager won't be called twice to get the related entity again.
     *
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToMany\OneToManyRelation::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToMany\OneToManyRelation::getName()
     * @covers \ExtendsFramework\ORM\Entity\Relation\OneToMany\OneToManyRelation::getRelated()
     */
    public function testGetRelated(): void
    {
        $collection = $this->createMock(CollectionInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('findByQuery')
            ->willReturn($collection);

        $property = $this->createMock(PropertyInterface::class);
        $property
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('3');

        $entity = $this->createMock(EntityInterface::class);
        $entity
            ->expects($this->once())
            ->method('getProperty')
            ->with('blog_id')
            ->willReturn($property);

        /**
         * @var EntityManagerInterface $entityManager
         * @var EntityInterface        $entity
         */
        $relation = new OneToManyRelation('comments', 'blog_id', 'blog_id', 'CommentEntity');

        $this->assertSame($collection, $relation->getRelated($entityManager, $entity));
        $this->assertSame($collection, $relation->getRelated($entityManager, $entity)); // Must read from cache.
    }
}
