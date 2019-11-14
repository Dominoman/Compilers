<?php

declare(strict_types=1);

namespace ACME\_05Asm;

/**
 * Class AbstractLexer
 * @package ACME\_05Asm
 */
abstract class AbstractLexer
{
    protected const EOF = "EOF";

    /**
     * @var string
     */
    private $input;

    /**
     * @var string
     */
    protected $c;

    /**
     * @var int
     */
    private $p;

    /**
     * AbstractLexer constructor.
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->input = $input;
        $this->c = strlen($input) > 0 ? $input[0] : self::EOF;
    }

    /**
     *
     */
    protected function consume(): void
    {
        $this->p++;
        $this->c = $this->p < strlen($this->input) ? $this->input[$this->p] : self::EOF;
    }

    /**
     * @return Token
     */
    abstract public function getNextToken(): Token;
}
