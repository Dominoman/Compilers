<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class VariableAst
 * @package ACME\_05Asm\Asts
 */
class VariableAst extends AbstractAst
{
    /**
     * @var string
     */
    public $variable;

    /**
     * VariableAst constructor.
     * @param string $variable
     */
    public function __construct(string $variable)
    {
        $this->variable = $variable;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->variable;
    }


    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $vmc->getVariable($this->variable);
    }
}
