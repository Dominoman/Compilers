<?php

declare(strict_types=1);

namespace ACME\_02Parser\Asts;

/**
 * Class OperatorAst
 * @package ACME\_02Parser\Asts
 */
class OperatorAst extends AbstractAst
{
    /**
     * @var string
     */
    public $operator;

    /**
     * @var AbstractAst
     */
    public $left;

    /**
     * @var AbstractAst
     */
    public $right;

    /**
     * OperatorAst constructor.
     * @param string $operator
     */
    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return "({$this->left}){$this->operator}({$this->right})";
    }
}
