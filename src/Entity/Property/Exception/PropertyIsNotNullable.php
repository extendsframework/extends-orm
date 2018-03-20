<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property\Exception;

use ExtendsFramework\ORM\Entity\Property\PropertyException;
use InvalidArgumentException;

class PropertyIsNotNullable extends InvalidArgumentException implements PropertyException
{
    /**
     * PropertyIsNotNullable constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'Null value is not allowed for property with name "%s".',
            $name
        ));
    }
}
