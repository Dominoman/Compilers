<?php

declare(strict_types=1);

namespace ACME\_02Parser\Asts;

/**
 * Class VariableAst
 * @package ACME\_02Parser\Asts
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
}
