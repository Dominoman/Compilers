<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class SetAst
 * @package ACME\_04Advanced\Asts
 */
class SetAst extends AbstractCommand
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

    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $this->right->compileMe($vmc);
        $vmc->setVariable($this->variable);
    }
}
