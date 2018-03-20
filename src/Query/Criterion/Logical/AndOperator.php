<?php
declare(strict_types=1);

namespace ExtendsFramework\ORM\Query\Criterion\Logical;

use ExtendsFramework\ORM\Query\Criterion\CriterionInterface;

class AndOperator implements CriterionInterface
{
    /**
     * Left expression.
     *
     * @var CriterionInterface
     */
    private $left;

    /**
     * Right expression.
     *
     * @var CriterionInterface
     */
    private $right;

    /**
     * AndOperator constructor.
     *
     * @param CriterionInterface $left
     * @param CriterionInterface $right
     */
    public function __construct(CriterionInterface $left, CriterionInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Get Left.
     *
     * @return CriterionInterface
     */
    public function getLeft(): CriterionInterface
    {
        return $this->left;
    }

    /**
     * Get Right.
     *
     * @return CriterionInterface
     */
    public function getRight(): CriterionInterface
    {
        return $this->right;
    }
}
