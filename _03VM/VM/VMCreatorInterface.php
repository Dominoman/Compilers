<?php

namespace ACME\_03VM\VM;

/**
 * Interface iVMCreator
 * @package ACME\_03VM\VM
 */
interface VMCreatorInterface
{
    /**
     * @param int $value
     */
    public function pushInt(int $value): void;

    /**
     * @param int $opcode
     */
    public function createOperator(int $opcode): void;

    /**
     * @param string $variable
     */
    public function setVariable(string $variable): void;

    /**
     * @param string $variable
     */
    public function getVariable(string $variable): void;

    /**
     * @param string $out
     */
    public function createPrintS(string $out): void;
}
