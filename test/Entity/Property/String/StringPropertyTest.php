<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property\String;

use PHPUnit\Framework\TestCase;

class StringPropertyTest extends TestCase
{
    /**
     * Populate.
     *
     * Test that populated value will be returned.
     *
     * @covers \ExtendsFramework\ORM\Entity\Property\String\StringProperty::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Property\String\StringProperty::doPopulate()
     */
    public function testPopulate(): void
    {
        $property = new StringProperty('name');
        $property->populate('John Doe');

        $this->assertSame('John Doe', $property->getValue());
    }

    /**
     * Value not a string.
     *
     * Test that property will only accept a string(able) value.
     *
     * @covers                   \ExtendsFramework\ORM\Entity\Property\String\StringProperty::__construct()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\String\StringProperty::doPopulate()
     * @covers                   \ExtendsFramework\ORM\Entity\Property\String\Exception\ValueNotAString::__construct()
     * @expectedException        \ExtendsFramework\ORM\Entity\Property\String\Exception\ValueNotAString
     * @expectedExceptionMessage Value for property "John Doe" must be a scalar or object with the __toString() method,
     *                           got type "array".
     */
    public function testValueNotAString(): void
    {
        $property = new StringProperty('John Doe');
        $property->populate([]);
    }
}
