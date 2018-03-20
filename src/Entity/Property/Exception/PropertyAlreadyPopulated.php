<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property\Exception;

use ExtendsFramework\ORM\Entity\Property\PropertyException;
use RuntimeException;

class PropertyAlreadyPopulated extends RuntimeException implements PropertyException
{
    /**
     * PropertyAlreadyPopulated constructor.
     *
     * @param string $property
     */
    public function __construct(string $property)
    {
        parent::__construct(sprintf(
            'Property with name "%s" is already populated.',
            $property
        ));
    }
}
