<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query\Criterion\Comparison;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;

class EqualToOperator implements CriterionInterface
{
    /**
     * Entity property.
     *
     * @var string
     */
    private $property;

    /**
     * Property value.
     *
     * @var mixed
     */
    private $value;

    /**
     * EqualOperator constructor.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function __construct(string $property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * Get Property.
     *
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * Get Value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
