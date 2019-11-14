<?php

declare(strict_types=1);

namespace ACME\_03VM\Asts;

use ACME\_03VM\VM\VMCreatorInterface;

/**
 * Class VariableAst
 * @package ACME\_03VM\Asts
 */
class VariableAst extends AbstractAst
{
    /**
     * @var string
     */
    public $variable;

    /**
     * VariableAbstractAst constructor.
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
