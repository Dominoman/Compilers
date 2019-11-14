<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class VariableAst
 * @package ACME\_04Advanced\Asts
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
