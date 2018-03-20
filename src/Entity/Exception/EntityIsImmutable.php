<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Exception;

use ExtendsFramework\ORM\Entity\EntityException;
use RuntimeException;

class EntityIsImmutable extends RuntimeException implements EntityException
{
    /**
     * EntityIsImmutable constructor.
     *
     * @param string $property
     */
    public function __construct(string $property)
    {
        parent::__construct('Entity is immutable and can not be changed.');
    }
}
