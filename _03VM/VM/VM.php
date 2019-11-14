<?php

declare(strict_types=1);

namespace ACME\_03VM\VM;

use Exception;

/**
 * Class VM
 * @package ACME
 */
class VM
{
    public const BRK = 0;
    public const PUSH = 1;
    public const LOAD = 2;
    public const STORE = 3;
    public const ADD = 4;
    public const SUB = 5;
    public const MUL = 6;
    public const DIV = 7;
    public const REM = 8;
    public const PRS = 9;
    public const PRI = 10;

    /**
     * @var array
     */
    private $memory = [];

    /**
     * @var int
     */
    private $pc = 0;

    /**
     * @var int
     */
    private $sp = 0;

    /**
     * VM constructor.
     * @param int $memorySize
     */
    public function __construct(int $memorySize = 2000)
    {
        $this->memory = array_fill(0, $memorySize, 0);
    }

    /**
     * @param int $data
     */
    public function assemble(int $data): void
    {
        $this->memory[$this->pc++] = $data;
    }

    /**
     *
     * @throws Exception
     */
    public function step(): void
    {
        switch ($this->memory[$this->pc++]) {
            case self::PUSH:
                $this->memory[$this->sp--] = $this->memory[$this->pc++];
                break;
            case self::LOAD:
                $this->memory[$this->sp + 1] = $this->memory[$this->memory[$this->sp + 1]];
                break;
            case self::STORE:
                $this->sp++;
                $this->memory[$this->memory[$this->sp]] = $this->memory[$this->sp + 1];
                $this->sp++;
                break;
            case self::ADD:
                $this->sp++;
                $this->memory[$this->sp + 1] = $this->memory[$this->sp + 1] + $this->memory[$this->sp];
                break;
            case self::SUB:
                $this->sp++;
                $this->memory[$this->sp + 1] = $this->memory[$this->sp + 1] - $this->memory[$this->sp];
                break;
            case self::MUL:
                $this->sp++;
                $this->memory[$this->sp + 1] = $this->memory[$this->sp + 1] * $this->memory[$this->sp];
                break;
            case self::DIV:
                $this->sp++;
                $this->memory[$this->sp + 1] = round($this->memory[$this->sp + 1] / $this->memory[$this->sp]);
                break;
            case self::REM:
                $this->sp++;
                $this->memory[$this->sp + 1] = $this->memory[$this->sp + 1] % $this->memory[$this->sp];
                break;
            case self::PRS:
                $len = $this->memory[$this->pc++];
                for ($i = 0; $i < $len; $i++) {
                    echo chr($this->memory[$this->pc++]);
                }
                break;
            case self::PRI:
                echo $this->memory[++$this->sp];
                break;
            default:
                throw new Exception("VM fault");
        }
    }

    /**
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->pc = 0;
        $this->sp = sizeof($this->memory) - 1;
        while ($this->memory[$this->pc] != self::BRK) {
            $this->step();
        }
    }
}
