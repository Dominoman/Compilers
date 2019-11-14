<?php

declare(strict_types=1);

namespace ACME\_03VM\VM;

class VMCreator implements VMCreatorInterface
{
    /**
     * @var VM
     */
    public $vm;

    /**
     * @var SymbolTable
     */
    private $symbolTable;

    /**
     * VMCreator constructor.
     */
    public function __construct()
    {
        $this->vm = new VM();
        $this->symbolTable = new SymbolTable(1000);
    }

    /**
     * @param int $value
     */
    public function pushInt(int $value): void
    {
        $this->vm->assemble(VM::PUSH);
        $this->vm->assemble($value);
    }

    /**
     * @param int $opcode
     */
    public function createOperator(int $opcode): void
    {
        $this->vm->assemble($opcode);
    }

    /**
     * @param string $variable
     */
    private function createPushVariable(string $variable): void
    {
        $this->vm->assemble(VM::PUSH);
        $addr = $this->symbolTable->getVariable($variable);
        $this->vm->assemble($addr);
    }

    /**
     * @param string $variable
     */
    public function setVariable(string $variable): void
    {
        $this->createPushVariable($variable);
        $this->vm->assemble(VM::STORE);
    }

    /**
     * @param string $variable
     */
    public function getVariable(string $variable): void
    {
        $this->createPushVariable($variable);
        $this->vm->assemble(VM::LOAD);
    }
    /**
     * @param string $out
     */
    public function createPrintS(string $out): void
    {
        $this->vm->assemble(VM::PRS);
        $this->vm->assemble(strlen($out));
        for (
            $i = 0; $i < strlen($out); $i++
        ) {
            $this->vm->assemble(ord($out[$i]));
        }
    }
}
