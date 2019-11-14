<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;
use ACME\_04Advanced\VM\VM;

/**
 * Class PrintAst
 * @package ACME\_04Advanced\Asts
 */
class PrintAst extends AbstractCommand
{
    /**
     * @var string
     */
    public $string;

    /**
     * @var ?AbstractAst
     */
    public $value = null;

    /**
     * PrintAst constructor.
     * @param AbstractAst|string $value
     */
    public function __construct($value)
    {
        if (is_string($value)) {
            $this->string = $value;
        } else {
            $this->value = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value == null ? "print '{$this->string}'" : "print {$this->value}";
    }


    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        if ($this->value == null) {
            $vmc->createPrintS($this->string);
        } else {
            $this->value->compileMe($vmc);
            $vmc->createOperator(VM::PRI);
        }
    }
}
