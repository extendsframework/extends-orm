<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation;

use PHPUnit\Framework\TestCase;

class AbstractRelationTest extends TestCase
{
    /**
     * Get name.
     *
     * Test that name will be returned.
     *
     * @covers \ExtendsFramework\ORM\Entity\Relation\AbstractRelation::__construct()
     * @covers \ExtendsFramework\ORM\Entity\Relation\AbstractRelation::getName()
     */
    public function testGetName(): void
    {
        $relation = new RelationStub('comments');

        $this->assertSame('comments', $relation->getName());
    }
}
