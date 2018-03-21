<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Relation\OneToOne\Exception;

use ExtendsFramework\ORM\Entity\Relation\RelationException;
use LogicException;

class NullRelationNotAllowed extends LogicException implements RelationException
{
    /**
     * NullRelationNotAllowed constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'Null value for relation "%s" is not allowed.',
            $name
        ));
    }
}
