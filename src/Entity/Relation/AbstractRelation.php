<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation;

abstract class AbstractRelation implements RelationInterface
{
    /**
     * Relation name.
     *
     * @var string
     */
    private $name;

    /**
     * AbstractRelation constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }
}
