<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property\String\Exception;

use ExtendsFramework\ORM\Entity\Property\PropertyException;
use InvalidArgumentException;

class ValueNotAString extends InvalidArgumentException implements PropertyException
{
    /**
     * ValueNotAString constructor.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function __construct(string $property, $value)
    {
        parent::__construct(sprintf(
            'Value for property "%s" must be a scalar or object with the __toString() method, got type "%s".',
            $property,
            gettype($value)
        ));
    }
}
