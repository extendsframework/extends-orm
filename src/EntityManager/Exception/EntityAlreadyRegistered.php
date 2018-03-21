<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager\Exception;

use ExtendsFramework\ORM\EntityManager\EntityManagerException;
use LogicException;

class EntityAlreadyRegistered extends LogicException implements EntityManagerException
{
    /**
     * EntityAlreadyRegistered constructor.
     *
     * @param string $entity
     */
    public function __construct(string $entity)
    {
        parent::__construct(sprintf(
            'Entity "%s" is already registered.',
            $entity
        ));
    }
}
