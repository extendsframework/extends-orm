<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity;

use ExtendsFramework\ORM\Entity\Property\PropertyInterface;
use ExtendsFramework\ORM\Entity\Relation\RelationInterface;

/**
 * @property PropertyInterface $name
 * @property RelationInterface $comments
 * @property null              $unknown
 */
class EntityStub extends AbstractEntity
{
    /**
     * @var PropertyInterface
     */
    protected $property;

    /**
     * @var RelationInterface
     */
    protected $relation;

    /**
     * EntityStub constructor.
     *
     * @param PropertyInterface $property
     * @param RelationInterface $relation
     */
    public function __construct(PropertyInterface $property, RelationInterface $relation)
    {
        $this->property = $property;
        $this->relation = $relation;
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this
            ->addProperty($this->property, true)
            ->addRelation($this->relation);
    }
}
