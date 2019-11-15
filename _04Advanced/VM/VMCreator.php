<?php

declare(strict_types=1);

namespace ACME\_04Advanced\VM;

/**
 * Class VMCreator
 * @package ACME\_04Advanced\VM
 */
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
     * @var int
     */
    private $labelCount;

    /**
     * @var int[]
     */
    private $labels = [];

    /**
     * @var string[]
     */
    private $delayedLabels = [];

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

    /**
     * @param string $label
     * @return string
     */
    public function allocateLabel(string $label): string
    {
        $this->labelCount++;
        return $label . $this->labelCount;
    }

    /**
     * @param string $labelName
     */
    public function createLabel(string $labelName): void
    {
        $this->labels[$labelName] = $this->vm->getPc();
        foreach ($this->delayedLabels as $pointer => $label) {
            if ($label == $labelName) {
                $this->vm->setMemory($pointer, $this->vm->getPc());
                unset($this->delayedLabels[$label]);
            }
        }
    }

    /**
     * @param string $labelName
     * @return int
     */
    private function getLabelValue(string $labelName): int
    {
        if (isset($this->labels[$labelName])) {
            return $this->labels[$labelName];
        }
        $this->delayedLabels[$this->vm->getPc()] = $labelName;
        return -1;
    }

    /**
     * @param string $labelName
     */
    public function createJump(string $labelName): void
    {
        $this->vm->assemble(VM::JUMP);
        $this->vm->assemble($this->getLabelValue($labelName));
    }

    /**
     * @param string $labelName
     */
    public function createJump0(string $labelName): void
    {
        $this->vm->assemble(VM::JUMP0);
        $this->vm->assemble($this->getLabelValue($labelName));
    }
}
