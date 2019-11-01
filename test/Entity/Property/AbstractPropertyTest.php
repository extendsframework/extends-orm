<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property;

use ExtendsFramework\ORM\Entity\Property\Exception\PropertyAlreadyPopulated;
use ExtendsFramework\ORM\Entity\Property\Exception\PropertyIsNotNullable;
use PHPUnit\Framework\TestCase;

class AbstractPropertyTest extends TestCase
{
    /**
     * Populate.
     *
     * Test that value will be populated and get methods will return proper values.
     *
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::populate()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::setValue()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::getName()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::getValue()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::isNullable()
     */
    public function testPopulate(): void
    {
        $property = new PropertyStub('name', true);
        $property->populate('John Doe');

        $this->assertSame('name', $property->getName());
        $this->assertSame('John Doe', $property->getValue());
        $this->assertTrue($property->isNullable());
    }

    /**
     * Property already populated.
     *
     * Test that an exception will be thrown when property is already populated.
     *
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::populate()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::setValue()
     * @covers \ExtendsFramework\ORM\Entity\Property\Exception\PropertyAlreadyPopulated::__construct()
     */
    public function testPropertyAlreadyPopulated(): void
    {
        $this->expectException(PropertyAlreadyPopulated::class);
        $this->expectExceptionMessage('Property with name "name" is already populated.');

        $property = new PropertyStub('name', true);
        $property
            ->populate('John Doe')
            ->populate('John Doe');
    }

    /**
     * Property is not nullable.
     *
     * Test that an exception will be thrown when a null value is passed to a not nullable property.
     *
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Property\AbstractProperty::populate()
     * @covers \ExtendsFramework\ORM\Entity\Property\Exception\PropertyIsNotNullable::__construct()
     */
    public function testPropertyIsNotNullable(): void
    {
        $this->expectException(PropertyIsNotNullable::class);
        $this->expectExceptionMessage('Null value is not allowed for property with name "name".');

        $property = new PropertyStub('name');
        $property->populate(null);
    }
}
