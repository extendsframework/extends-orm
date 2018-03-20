<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property;

interface PropertyInterface
{
    /**
     * Get property name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get property value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * If property is nullable.
     *
     * @return bool
     */
    public function isNullable(): bool;

    /**
     * Populate property.
     *
     * @param mixed $value
     * @return PropertyInterface
     * @throws PropertyException When the property is already populated or is the value is not ...
     */
    public function populate($value): PropertyInterface;
}
