<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query\Criterion\Logical;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;
use PHPUnit\Framework\TestCase;

class AndOperatorTest extends TestCase
{
    /**
     * Get methods.
     *
     * Test that get methods will return correct values.
     *
     * @covers \ExtendsFramework\ORM\Query\Criterion\Logical\AndOperator::__construct()
     * @covers \ExtendsFramework\ORM\Query\Criterion\Logical\AndOperator::getLeft()
     * @covers \ExtendsFramework\ORM\Query\Criterion\Logical\AndOperator::getRight()
     */
    public function testGetMethods(): void
    {
        $left = $this->createMock(CriterionInterface::class);

        $right = $this->createMock(CriterionInterface::class);

        /**
         * @var CriterionInterface $left
         * @var CriterionInterface $right
         */
        $operator = new AndOperator($left, $right);

        $this->assertSame($left, $operator->getLeft());
        $this->assertSame($right, $operator->getRight());
    }
}
