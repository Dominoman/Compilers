<?php

declare(strict_types=1);

namespace ACME\_02Parser;

/**
 * Class AbstractLexer
 * @package ACME\_02Parser
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
    protected $currentChar;

    /**
     * @var int
     */
    private $pointer = 0;

    /**
     * AbstractLexer constructor.
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->input = $input;
        $this->currentChar = strlen($input) > 0 ? $input[0] : self::EOF;
    }

    /**
     *
     */
    protected function consume(): void
    {
        $this->pointer++;
        $this->currentChar = $this->pointer < strlen($this->input) ? $this->input[$this->pointer] : self::EOF;
    }

    /**
     * @return Token
     */
    abstract public function getNextToken(): Token;
}
