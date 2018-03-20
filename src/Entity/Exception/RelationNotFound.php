<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Exception;

use ExtendsFramework\ORM\Entity\EntityException;
use InvalidArgumentException;

class RelationNotFound extends InvalidArgumentException implements EntityException
{
    /**
     * RelationNotFound constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'Relation with name "%s" can not be found.',
            $name
        ));
    }
}
