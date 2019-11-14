<?php

declare(strict_types=1);

namespace ACME\_05Asm\VM;

/**
 * Class VMAsmExporter
 * @package ACME\_05Asm\VM
 */
class VMAsmExporter implements VMCreatorInterface
{
    /**
     * @var string
     */
    private $codeseg = "";

    /**
     * @var string
     */
    private $strings = "";

    /**
     * @var int
     */
    private $stringcount = 0;

    /**
     * @var string[]
     */
    private $variables = [];

    /**
     * @var int
     */
    private $count = 0;

    /**
     * @param int $value
     */
    public function pushInt(int $value): void
    {
        $this->codeseg .= "    lda #<$value
    ldx #>$value
    jsr _pushax
";
    }

    /**
     * @param int $opcode
     */
    public function createOperator(int $opcode): void
    {
        switch ($opcode) {
            case VM::ADD:
                $this->codeseg .= "    jsr _add\r\n";
                break;
            case VM::SUB:
                $this->codeseg .= "    jsr _sub\r\n";
                break;
            case VM::MUL:
                $this->codeseg .= "    jsr _mul\r\n";
                break;
            case VM::DIV:
                $this->codeseg .= "    jsr _div\r\n";
                break;
            case VM::REM:
                $this->codeseg .= "    jsr _rem\r\n";
                break;
            case VM::PRI:
                $this->codeseg .= "    jsr _printint\r\n";
                break;
            case VM::LESS:
                $this->codeseg .= "    jsr _less\r\n";
                break;
            case VM::EQ:
                $this->codeseg .= "    jsr _eq\r\n";
                break;
            case VM::GREATER:
                $this->codeseg .= "    jsr _more\r\n";
                break;
            case VM::AND:
                $this->codeseg .= "    jsr _and\r\n";
                break;
            case VM::OR:
                $this->codeseg .= "    jst _or\r\n";
                break;
        }
    }

    /**
     * @param string $variable
     */
    public function setVariable(string $variable): void
    {
        $this->variables[$variable] = 1;
        $this->codeseg .= "    ldy #0
    lda (sp),y
    sta $variable
    iny
    lda (sp),y
    sta $variable+1
    jsr _drop1
";
    }

    /**
     * @param string $variable
     */
    public function getVariable(string $variable): void
    {
        $this->variables[$variable] = 1;
        $this->codeseg .= "    lda $variable
    ldx $variable+1
    jsr _pushax
";
    }

    /**
     * @param string $out
     */
    public function createPrintS(string $out): void
    {
        $out = strtoupper($out);
        $this->codeseg .= "    lda #<_S$this->stringcount
    ldy #>_S$this->stringcount
    jsr \$AB1E
";
        $this->strings .= "_S$this->stringcount: .text \"$out\"
    .byte 0
";
        $this->stringcount++;
    }

    /**
     * @param string $template
     * @return string
     */
    public function getSource(string $template): string
    {
        $variableSeg = "";
        foreach (array_keys($this->variables) as $v) {
            $variableSeg .= "$v: .word 0\r\n";
        }
        $tmp = str_replace("%varseg%", $variableSeg, $template);
        $tmp = str_replace("%stringseg%", $this->strings, $tmp);
        return str_replace("%codeseg%", $this->codeseg, $tmp);
    }

    /**
     * @param string $label
     * @return string
     */
    public function allocateLabel(string $label): string
    {
        $this->count++;
        return $label . $this->count;
    }

    /**
     * @param string $labelName
     */
    public function createLabel(string $labelName): void
    {
        $this->codeseg .= "$labelName:\r\n";
    }

    /**
     * @param string $labelName
     */
    public function createJump(string $labelName): void
    {
        $this->codeseg .= "    jmp $labelName\r\n";
    }

    /**
     * @param string $labelName
     */
    public function createN0Jump(string $labelName): void
    {
        $this->codeseg .= "    ldy #0
    lda (sp),y
    iny
    ora (sp),y
    pha
    jsr _drop1
    pla
    beq !longjumpfix+
    jmp $labelName
!longjumpfix:\r\n";
    }
}
