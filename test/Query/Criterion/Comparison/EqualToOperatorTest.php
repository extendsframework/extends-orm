<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query\Criterion\Comparison;

use PHPUnit\Framework\TestCase;

class EqualToOperatorTest extends TestCase
{
    /**
     * Get methods.
     *
     * Test that get methods will return correct values.
     *
     * @covers \ExtendsFramework\ORM\Query\Criterion\Comparison\EqualToOperator::__construct()
     * @covers \ExtendsFramework\ORM\Query\Criterion\Comparison\EqualToOperator::getProperty()
     * @covers \ExtendsFramework\ORM\Query\Criterion\Comparison\EqualToOperator::getValue()
     */
    public function testGetMethods(): void
    {
        $operator = new EqualToOperator('name', 'John Doe');

        $this->assertSame('name', $operator->getProperty());
        $this->assertSame('John Doe', $operator->getValue());
    }
}
