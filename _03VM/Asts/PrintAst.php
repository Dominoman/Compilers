<?php

declare(strict_types=1);

namespace ACME\_03VM\Asts;

use ACME\_03VM\VM\VMCreatorInterface;
use ACME\_03VM\VM\VM;

/**
 * Class PrintAst
 * @package ACME\_03VM\Asts
 */
class PrintAst extends AbstractAst
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
     * PrintAbstractAst constructor.
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
