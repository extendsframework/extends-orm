<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation\OneToMany;

use ExtendsFramework\ORM\Collection\CollectionInterface;
use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Entity\Relation\AbstractRelation;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;
use ExtendsFramework\ORM\Query\Criterion\Comparison\EqualToOperator;
use ExtendsFramework\ORM\Query\Query;

class OneToManyRelation extends AbstractRelation
{
    /**
     * Local property name.
     *
     * @var string
     */
    private $local;

    /**
     * Foreign property name.
     *
     * @var string
     */
    private $foreign;

    /**
     * Entity name.
     *
     * @var string
     */
    private $alias;

    /**
     * Related collection.
     *
     * @var CollectionInterface
     */
    private $related;

    /**
     * If relation is initialized.
     *
     * @var bool
     */
    private $initialized = false;

    /**
     * OneToManyRelation constructor.
     *
     * @param string $name
     * @param string $local
     * @param string $foreign
     * @param string $alias
     */
    public function __construct(string $name, string $local, string $foreign, string $alias)
    {
        parent::__construct($name);

        $this->local = $local;
        $this->foreign = $foreign;
        $this->alias = $alias;
    }

    /**
     * @inheritDoc
     */
    public function getRelated(EntityManagerInterface $entityManager, EntityInterface $entity): CollectionInterface
    {
        if (!$this->initialized) {
            $property = $entity->getProperty($this->local);

            $this->related = $entityManager->findByQuery(new Query(
                new EqualToOperator($this->foreign, $property->getValue())
            ), $this->alias);

            $this->initialized = true;
        }

        return $this->related;
    }
}
