<?php

declare(strict_types=1);

namespace ACME\_02Parser\Asts;

/**
 * Class SetAst
 * @package ACME\_02Parser\Asts
 */
class SetAst extends AbstractAst
{
    /**
     * @var string
     */
    public $variable;

    /**
     * @var AbstractAst
     */
    public $right;

    /**
     * SetAst constructor.
     * @param string $variable
     * @param AbstractAst $right
     */
    public function __construct(string $variable, AbstractAst $right)
    {
        $this->variable = $variable;
        $this->right = $right;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return "{$this->variable}={$this->right}";
    }
}
