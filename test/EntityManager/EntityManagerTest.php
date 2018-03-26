<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Query\QueryInterface;
use ExtendsFramework\ORM\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;

class EntityManagerTest extends TestCase
{
    /**
     * Find by id.
     *
     * Test that method will return instance when called with identifier and entity.
     *
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::addRepository()
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::findById()
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::getRepository()
     */
    public function testFindById(): void
    {
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(RepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('findById')
            ->with('3')
            ->willReturn($entity);

        /**
         * @var RepositoryInterface $repository
         */
        $manager = new EntityManager();
        $manager->addRepository($repository, 'BlogEntity');

        $this->assertSame($entity, $manager->findById('3', 'BlogEntity'));
        $this->assertSame($entity, $manager->findById('3', 'BlogEntity')); // Must read from internal entity map.
    }

    /**
     * Find by query.
     *
     * Test that method will return collection when called with query and entity.
     *
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::addRepository()
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::findByQuery()
     * @covers \ExtendsFramework\ORM\EntityManager\EntityManager::getRepository()
     */
    public function testFindByQuery(): void
    {
        $collection = $this->createMock(CollectionInterface::class);

        $query = $this->createMock(QueryInterface::class);

        $repository = $this->createMock(RepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('findByQuery')
            ->with($query)
            ->willReturn($collection);

        /**
         * @var RepositoryInterface $repository
         * @var QueryInterface      $query
         */
        $manager = new EntityManager();
        $manager->addRepository($repository, 'BlogEntity');

        $this->assertSame($collection, $manager->findByQuery($query, 'BlogEntity'));
    }

    /**
     * Entity not supported.
     *
     * Test that an exception will be thrown when there is no repository found for the entity.
     *
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::addRepository()
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::findByQuery()
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::getRepository()
     * @covers                   \ExtendsFramework\ORM\EntityManager\Exception\EntityNotSupported::__construct
     * @expectedException        \ExtendsFramework\ORM\EntityManager\Exception\EntityNotSupported
     * @expectedExceptionMessage Entity "BlogEntity" is not supported by the entity manager.
     */
    public function testEntityNotSupported(): void
    {
        $manager = new EntityManager();
        $manager->findById('3', 'BlogEntity');
    }

    /**
     * Entity not supported.
     *
     * Test that an exception will be thrown when there is no repository found for the entity.
     *
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::addRepository()
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::findByQuery()
     * @covers                   \ExtendsFramework\ORM\EntityManager\EntityManager::getRepository()
     * @covers                   \ExtendsFramework\ORM\EntityManager\Exception\EntityAlreadyRegistered::__construct
     * @expectedException        \ExtendsFramework\ORM\EntityManager\Exception\EntityAlreadyRegistered
     * @expectedExceptionMessage Entity "BlogEntity" is already registered.
     */
    public function testEntityAlreadyRegistered(): void
    {
        $repository = $this->createMock(RepositoryInterface::class);

        /**
         * @var RepositoryInterface $repository
         */
        $manager = new EntityManager();
        $manager
            ->addRepository($repository, 'BlogEntity')
            ->addRepository($repository, 'BlogEntity');
    }
}
