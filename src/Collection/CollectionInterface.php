<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Collection;

use ExtendsFramework\ORM\Entity\EntityInterface;
use Iterator;

interface CollectionInterface extends Iterator
{
    /**
     * Get first entity.
     *
     * NULL will be returned when collection is empty.
     *
     * @return EntityInterface|null
     */
    public function getFirst(): ?EntityInterface;

    /**
     * If collection is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Get current entity.
     *
     * @return EntityInterface
     */
    public function current(): EntityInterface;
}
