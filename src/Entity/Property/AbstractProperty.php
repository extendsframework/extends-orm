<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property;

use ExtendsFramework\ORM\Entity\Property\Exception\PropertyAlreadyPopulated;
use ExtendsFramework\ORM\Entity\Property\Exception\PropertyIsNotNullable;

abstract class AbstractProperty implements PropertyInterface
{
    /**
     * Property name.
     *
     * @var string
     */
    private $name;

    /**
     * Property value.
     *
     * @var mixed
     */
    private $value;

    /**
     * If property is nullable.
     *
     * @var bool
     */
    private $nullable;

    /**
     * If property is populated.
     *
     * @var bool
     */
    private $populated = false;

    /**
     * AbstractProperty constructor.
     *
     * @param string    $name
     * @param bool|null $nullable
     */
    public function __construct(string $name, bool $nullable = null)
    {
        $this->name = $name;
        $this->nullable = $nullable ?? false;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @inheritDoc
     */
    public function populate($value): PropertyInterface
    {
        if ($this->populated) {
            throw new PropertyAlreadyPopulated($this->getName());
        }

        if ($value !== null) {
            $this->doPopulate($value);
        } elseif (!$this->nullable) {
            throw new PropertyIsNotNullable($this->getName());
        }

        $this->populated = true;

        return $this;
    }

    /**
     * Set value.
     *
     * @param mixed $value
     * @return AbstractProperty
     */
    protected function setValue($value): AbstractProperty
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set value.
     *
     * Validate and set value. Value be converted to the desired type if needed.
     *
     * @param mixed $value
     * @return AbstractProperty
     * @throws PropertyException When value is not of the expected type or can not be converted to the expected type.
     */
    abstract protected function doPopulate($value): AbstractProperty;
}
