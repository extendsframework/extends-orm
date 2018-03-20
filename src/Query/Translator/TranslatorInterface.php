<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query\Translator;

use ExtendsFramework\ORM\Entity\EntityInterface;
use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;

interface TranslatorInterface
{
    /**
     * Translate criteria.
     *
     * @param CriterionInterface $criteria The criteria specification to translate.
     * @param EntityInterface    $entity   The entity where this translation is for.
     * @return mixed
     */
    public function translate(CriterionInterface $criteria, EntityInterface $entity);
}
