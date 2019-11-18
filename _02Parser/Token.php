<?php

declare(strict_types=1);

namespace ACME\_02Parser;

/**
 * Class Token
 * @package ACME\_02Parser
 */
class Token
{
    public const TTEOF = -1;
    public const TTID = -2;
    public const TTNUMBER = -3;
    public const TTSTRING = -4;
    public const TTPRINT = -5;

    /**
     * @var int
     */
    private $tokenType;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Token constructor.
     * @param int $tokenType
     * @param mixed $value
     */
    public function __construct(int $tokenType, $value = 0)
    {
        $this->tokenType = $tokenType;
        $this->value = $value;
    }

    /**
     * @param int $tokenType
     * @return string
     */
    public static function toString(int $tokenType): string
    {
        switch ($tokenType) {
            case self::TTEOF:
                return "<EOF>";
            case self::TTID:
                return "<ID>";
            case self::TTNUMBER:
                return "<NUMBER>";
            case self::TTSTRING:
                return "<STRING>";
            case self::TTPRINT:
                return "<PRINT>";
            default:
                return "<" . chr($tokenType) . ">";
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        switch ($this->tokenType) {
            case self::TTID:
                return "<ID:$this->value>";
            case self::TTNUMBER:
                return "<NUMBER:$this->value>";
            case self::TTSTRING:
                return "<STRING:$this->value>";
            default:
                return self::toString($this->tokenType);
        }
    }

    /**
     * @return int
     */
    public function getTokenType(): int
    {
        return $this->tokenType;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
