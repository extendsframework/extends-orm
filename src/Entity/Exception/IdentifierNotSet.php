<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Exception;

use ExtendsFramework\ORM\Entity\EntityException;
use LogicException;

class IdentifierNotSet extends LogicException implements EntityException
{
    /**
     * IdentifierNotSet constructor.
     */
    public function __construct()
    {
        parent::__construct('No identifier set for entity.');
    }
}
