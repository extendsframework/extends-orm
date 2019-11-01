<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Entity\Property;

class PropertyStub extends AbstractProperty
{
    /**
     * @inheritDoc
     */
    protected function doPopulate($value): AbstractProperty
    {
        return $this->setValue($value);
    }
}
