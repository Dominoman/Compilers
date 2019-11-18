<?php

declare(strict_types=1);

namespace ACME\_03VM;

use Exception;

/**
 * Class ScriptLexer
 * @package ACME\_VM
 */
class ScriptLexer extends AbstractLexer
{
    private const NONE = 0;
    private const WHITESPACE = 1;
    private const ALPHA = 2;
    private const NUMBER = 4;
    private const QUOTE =  8;
    private const COMMENT = 16;

    /**
     * @var array
     */
    private $ctype;

    /**
     * ScriptLexer constructor.
     * @param string $input
     */
    public function __construct(string $input)
    {
        parent::__construct($input);
        $this->ctype = array_fill(0, 256, self::NONE);
        $this->setFlag(0, ' ', self::WHITESPACE);
        $this->setFlag('a', 'z', self::ALPHA);
        $this->setFlag('A', 'Z', self::ALPHA);
        $this->setFlag('0', '9', self::ALPHA);
        $this->setFlag('0', '9', self::NUMBER);
        $this->setFlag('_', '_', self::ALPHA);
        $this->setFlag('"', '"', self::QUOTE);
        $this->setFlag('/', '/', self::COMMENT);
    }

    /**
     * @param $low
     * @param $hi
     * @param int $flag
     */
    private function setFlag($low, $hi, int $flag): void
    {
        $low = is_string($low) ? ord($low) : $low;
        $hi = is_string($hi) ? ord($hi) : $hi;
        while ($low <= $hi) {
            $this->ctype[$low++] |= $flag;
        }
    }

    /**
     * @param int $flag
     * @return bool
     */
    private function hasFlag(int $flag): bool
    {
        $ch = ord($this->currentChar);
        $f = $this->ctype[$ch] ?? self::ALPHA;
        return ($f & $flag) > 0;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getNextToken(): Token
    {
        while ($this->currentChar != self::EOF) {
            if ($this->hasFlag(self::WHITESPACE)) {
                $this->skipWhitespaces();
            } elseif ($this->hasFlag(self::COMMENT)) {
                $this->consume();
                if ($this->currentChar == '/') {
                    $this->skipCommentLine();
                } else {
                    return new Token(ord('/'));
                }
            } elseif ($this->hasFlag(self::NUMBER)) {
                return $this->getNumber();
            } elseif ($this->hasFlag(self::ALPHA)) {
                return $this->getID();
            } elseif ($this->hasFlag(self::QUOTE)) {
                return $this->getString($this->currentChar);
            } else {
                $tmp = $this->currentChar;
                $this->consume();
                return new Token(ord($tmp));
            }
        }
        return new Token(Token::TTEOF);
    }

    /**
     * @return Token
     */
    private function getID(): Token
    {
        $tmp = '';
        while ($this->hasFlag(self::ALPHA) && $this->currentChar != self::EOF) {
            $tmp .= $this->currentChar;
            $this->consume();
        }
        return $tmp === "print" ? new Token(Token::TTPRINT) : new Token(Token::TTID, $tmp);
    }

    /**
     * @return Token
     */
    private function getNumber(): Token
    {
        $tmp = '';
        while ($this->hasFlag(self::NUMBER)) {
            $tmp .= $this->currentChar;
            $this->consume();
        }
        return new Token(Token::TTNUMBER, intval($tmp));
    }

    /**
     * @param string $ch
     * @return Token
     * @throws Exception
     */
    private function getString(string $ch): Token
    {
        $tmp = '';
        $this->consume();
        while ($this->currentChar != $ch) {
            if ($this->currentChar == self::EOF) {
                throw new Exception("Missing closing quote!");
            }
            $tmp .= $this->currentChar;
            $this->consume();
        }
        $this->consume();
        return new Token(Token::TTSTRING, $tmp);
    }

    /**
     *
     */
    private function skipCommentLine(): void
    {
        while (!in_array($this->currentChar, ["\n","\r",self::EOF])) {
            $this->consume();
        }
    }

    /**
     *
     */
    private function skipWhitespaces(): void
    {
        while ($this->hasFlag(self::WHITESPACE)) {
            $this->consume();
        }
    }
}
