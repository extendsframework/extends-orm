<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation\OneToOne;

use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Entity\Relation\AbstractRelation;
use ExtendsFramework\ORM\Entity\Relation\OneToOne\Exception\NullRelationNotAllowed;
use ExtendsFramework\ORM\EntityManager\EntityManagerInterface;
use ExtendsFramework\ORM\EntityManager\Exception\EntityNotSupported;

class OneToOneRelation extends AbstractRelation
{
    /**
     * Local property.
     *
     * @var string
     */
    private $local;

    /**
     * Entity name.
     *
     * @var string
     */
    private $entity;

    /**
     * If empty relation is allowed.
     *
     * @var bool
     */
    private $allowEmpty;

    /**
     * Related entity.
     *
     * Can be null when empty relation is allowed.
     *
     * @var EntityInterface|null
     */
    private $related;

    /**
     * If relation is initialized.
     *
     * @var bool
     */
    private $initialized = false;

    /**
     * OneToOneRelation constructor.
     *
     * @param string    $name       Relation name.
     * @param string    $local      Local property.
     * @param string    $entity     Entity class.
     * @param bool|null $allowEmpty If empty relation is allowed.
     */
    public function __construct(
        string $name,
        string $local,
        string $entity,
        bool $allowEmpty = null
    ) {
        parent::__construct($name);

        $this->local = $local;
        $this->entity = $entity;
        $this->allowEmpty = $allowEmpty ?? true;
    }

    /**
     * @inheritDoc
     * @throws NullRelationNotAllowed When related entity is null and null relation is not allowed.
     * @throws EntityNotSupported     When related entity is not registered by entity manager.
     */
    public function getRelated(EntityManagerInterface $entityManager, EntityInterface $entity): ?EntityInterface
    {
        if ($this->initialized === false) {
            $property = $entity->getProperty($this->local);

            $related = $entityManager->findById($property->getValue(), $this->entity);
            if ($related === null && $this->allowEmpty === false) {
                throw new NullRelationNotAllowed($this->getName());
            }

            $this->initialized = true;
            $this->related = $related;
        }

        return $this->related;
    }
}
