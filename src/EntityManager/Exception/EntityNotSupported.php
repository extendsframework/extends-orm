<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\EntityManager\Exception;

use ExtendsFramework\ORM\EntityManager\EntityManagerException;
use LogicException;

class EntityNotSupported extends LogicException implements EntityManagerException
{
    /**
     * RepositoryNotFound constructor.
     *
     * @param string $entity
     */
    public function __construct(string $entity)
    {
        parent::__construct(sprintf(
            'Entity "%s" is not supported by the entity manager.',
            $entity
        ));
    }
}
