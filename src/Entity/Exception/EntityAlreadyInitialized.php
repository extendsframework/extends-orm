<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Exception;

use ExtendsFramework\ORM\Entity\EntityException;
use RuntimeException;

class EntityAlreadyInitialized extends RuntimeException implements EntityException
{
    /**
     * EntityAlreadyInitialized constructor.
     */
    public function __construct()
    {
        parent::__construct('Entity can only be initialized once.');
    }
}
