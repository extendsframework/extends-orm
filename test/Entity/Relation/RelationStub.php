<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation;

use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;

class RelationStub extends AbstractRelation
{
    /**
     * @inheritDoc
     */
    public function getRelated(EntityManagerInterface $entityManager, EntityInterface $entity)
    {
    }
}
