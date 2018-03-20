<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Exception;

use ExtendsFramework\ORM\Entity\EntityException;
use InvalidArgumentException;

class PropertyNotFound extends InvalidArgumentException implements EntityException
{
    /**
     * PropertyNotFound constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'Property with name "%s" can not be found.',
            $name
        ));
    }
}
