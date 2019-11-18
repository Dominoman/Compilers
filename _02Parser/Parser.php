<?php

declare(strict_types=1);

namespace ACME\_02Parser;

use Exception;

/**
 * Class Parser
 * @package ACME\_02Parser
 */
class Parser
{
    /**
     * @var AbstractLexer
     */
    private $input;

    /**
     * @var array
     */
    private $lookahead = [];

    /**
     * @var int
     */
    private $p = 0;

    /**
     * Parser constructor.
     * @param AbstractLexer $input
     */
    protected function __construct(AbstractLexer $input)
    {
        $this->input = $input;
        $this->sync(1);
    }

    /**
     * @param int $i
     */
    private function sync(int $i): void
    {
        $n = $this->p + $i - count($this->lookahead);
        $this->fill($n);
    }

    /**
     * @param int $n
     */
    private function fill(int $n): void
    {
        for ($i = 0; $i < $n; $i++) {
            $this->lookahead[] = $this->input->getNextToken();
        }
    }

    /**
     *
     */
    protected function consume(): void
    {
        $this->p++;
        if ($this->p == count($this->lookahead)) {
            $this->p = 0;
            $this->lookahead = [];
        }
        $this->sync(1);
    }

    /**
     * @param int $i
     * @return Token
     */
    protected function lt(int $i): Token
    {
        $this->sync($i);
        return $this->lookahead[$this->p + $i - 1];
    }

    /**
     * @param int $i
     * @return int
     */
    protected function la(int $i): int
    {
        return $this->lt($i)->getTokenType();
    }

    /**
     * @param int $i
     * @throws Exception
     */
    protected function match(int $i): void
    {
        if ($i == $this->la(1)) {
            $this->consume();
            return;
        }
        throw new Exception("Token mismatch! Expected: " . Token::toString($i) . ", found:" . $this->lt(1));
    }
}
