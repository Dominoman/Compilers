<?php

namespace ACME\_04Advanced\VM;

/**
 * Interface VMCreatorInterface
 * @package ACME\_04Advanced\VM
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

    /**
     * @param string $label
     * @return string
     */
    public function allocateLabel(string $label): string;

    /**
     * @param string $labelName
     */
    public function createLabel(string $labelName): void;

    /**
     * @param string $labelName
     */
    public function createJump(string $labelName): void;

    /**
     * @param string $labelName
     */
    public function createN0Jump(string $labelName): void;
}
