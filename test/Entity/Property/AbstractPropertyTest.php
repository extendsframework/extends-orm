<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property;

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
     * @covers                   \ExtendsFramework\ORM\Entity\Property\AbstractProperty::__construct()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\AbstractProperty::populate()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\AbstractProperty::setValue()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\Exception\PropertyAlreadyPopulated::__construct()
     * @expectedException        \ExtendsFramework\ORM\Entity\Property\Exception\PropertyAlreadyPopulated
     * @expectedExceptionMessage Property with name "name" is already populated.
     */
    public function testPropertyAlreadyPopulated(): void
    {
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
     * @covers                   \ExtendsFramework\ORM\Entity\Property\AbstractProperty::__construct()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\AbstractProperty::populate()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\Exception\PropertyIsNotNullable::__construct()
     * @expectedException        \ExtendsFramework\ORM\Entity\Property\Exception\PropertyIsNotNullable
     * @expectedExceptionMessage Null value is not allowed for property with name "name".
     */
    public function testPropertyIsNotNullable(): void
    {
        $property = new PropertyStub('name');
        $property->populate(null);
    }
}

class PropertyStub extends AbstractProperty
{
    /**
     * @inheritDoc
     */
    protected function doPopulate($value): AbstractProperty
    {
        return $this->setValue($value);
    }
}
