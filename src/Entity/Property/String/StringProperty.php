<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property\String;

use ExtendsFramework\ORM\Entity\Property\AbstractProperty;
use ExtendsFramework\ORM\Entity\Property\String\Exception\ValueNotAString;
use InvalidArgumentException;
use function is_scalar;
use function method_exists;

class StringProperty extends AbstractProperty
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    protected function doPopulate($value): AbstractProperty
    {
        if (is_scalar($value) === false && method_exists($value, '__toString') === false) {
            throw new ValueNotAString($this->getName(), $value);
        }

        return $this->setValue((string)$value);
    }
}
