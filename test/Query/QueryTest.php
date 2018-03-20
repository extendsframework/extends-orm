<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    /**
     * Get methods.
     *
     * Test that get methods will return correct value.
     *
     * @covers \ExtendsFramework\ORM\Query\Query::__construct()()
     * @covers \ExtendsFramework\ORM\Query\Query::getCriteria()
     * @covers \ExtendsFramework\ORM\Query\Query::getOffset()
     * @covers \ExtendsFramework\ORM\Query\Query::getLimit()
     */
    public function testGetMethods(): void
    {
        $criterion = $this->createMock(CriterionInterface::class);

        /**
         * @var CriterionInterface $criterion
         */
        $query = new Query($criterion, 15, 5);

        $this->assertSame($criterion, $query->getCriteria());
        $this->assertSame(15, $query->getLimit());
        $this->assertSame(5, $query->getOffset());
    }
}
