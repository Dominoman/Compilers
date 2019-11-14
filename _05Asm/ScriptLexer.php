<?php

declare(strict_types=1);

namespace ACME\_05Asm;

use Exception;

/**
 * Class ScriptLexer
 * @package ACME\_05Asm
 */
class ScriptLexer extends AbstractLexer
{
    private const NONE = 0;
    private const WHITESPACE = 1;
    private const ALPHA = 2;
    private const NUMBER = 4;
    private const QUOTE = 8;
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
        $this->addWhiteSpaces(0, ' ');
        $this->addAlphas('a', 'z');
        $this->addAlphas('A', 'Z');
        $this->addAlphas('0', '9');
        $this->addAlpha('_');
        $this->addQuote('"');
        $this->addComment('/');
        $this->parseNumber();
    }

    /**
     * @param mixed $low
     * @param mixed $hi
     */
    private function addWhiteSpaces($low, $hi): void
    {
        if (is_string($low)) {
            $low = ord($low);
        }
        if (is_string($hi)) {
            $hi = ord($hi);
        }
        while ($low <= $hi) {
            $this->ctype[$low++] |= self::WHITESPACE;
        }
    }

    /**
     * @param mixed $low
     * @param mixed $hi
     */
    private function addAlphas($low, $hi): void
    {
        if (is_string($low)) {
            $low = ord($low);
        }
        if (is_string($hi)) {
            $hi = ord($hi);
        }
        while ($low <= $hi) {
            $this->ctype[$low++] |= self::ALPHA;
        }
    }

    /**
     * @param string|int $ch
     */
    private function addAlpha($ch): void
    {
        if (is_string($ch)) {
            $ch = ord($ch);
        }
        $this->ctype[$ch] |= self::ALPHA;
    }

    /**
     * @param string|int $ch
     */
    private function addQuote($ch): void
    {
        if (is_string($ch)) {
            $ch = ord($ch);
        }
        $this->ctype[$ch] |= self::QUOTE;
    }

    /**
     * @param string|int $ch
     */
    private function addComment($ch): void
    {
        if (is_string($ch)) {
            $ch = ord($ch);
        }
        $this->ctype[$ch] |= self::COMMENT;
    }

    /**
     *
     */
    private function parseNumber(): void
    {
        for ($i = ord('0'); $i <= ord('9'); $i++) {
            $this->ctype[$i] |= self::NUMBER;
        }
    }

    /**
     * @param int $flag
     * @return bool
     */
    private function hasFlag(int $flag): bool
    {
        $ch = ord($this->c);
        $f = 0 <= $ch && $ch < count($this->ctype) ? $this->ctype[$ch] : self::ALPHA;
        return ($f & $flag) > 0;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getNextToken(): Token
    {
        while ($this->c != self::EOF) {
            if ($this->hasFlag(self::WHITESPACE)) {
                $this->skipWhitespaces();
            } elseif ($this->hasFlag(self::COMMENT)) {
                $this->consume();
                if ($this->c == '/') {
                    $this->skipCommentLine();
                } else {
                    return new Token(ord('/'));
                }
            } elseif ($this->hasFlag(self::NUMBER)) {
                return $this->getNumber();
            } elseif ($this->hasFlag(self::ALPHA)) {
                return $this->getID();
            } elseif ($this->hasFlag(self::QUOTE)) {
                return $this->getString($this->c);
            } else {
                $tmp = $this->c;
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
        $tmp = "";
        while ($this->hasFlag(self::ALPHA) && $this->c != self::EOF) {
            $tmp .= $this->c;
            $this->consume();
        }
        return new Token(Token::TTID, $tmp);
    }

    /**
     * @return Token
     */
    private function getNumber(): Token
    {
        $tmp = "";
        while ($this->hasFlag(self::NUMBER)) {
            $tmp .= $this->c;
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
        $tmp = "";
        $this->consume();
        while ($this->c != $ch) {
            if ($this->c == self::EOF) {
                throw new Exception("Missing closing quote!");
            }
            $tmp .= $this->c;
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
        while ($this->c != "\n" && $this->c != "\r" && $this->c != self::EOF) {
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
