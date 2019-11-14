<?php

declare(strict_types=1);

namespace ACME\_02Parser\Asts;

/**
 * Class PrintAst
 * @package ACME\_02Parser\Asts
 */
class PrintAst extends AbstractAst
{
    /**
     * @var string
     */
    public $string;

    /**
     * @var AbstractAst
     */
    public $value = null;

    /**
     * PrintAst constructor.
     * @param AbstractAst|string $value
     */
    public function __construct($value)
    {
        if (is_string($value)) {
            $this->string = $value;
        } else {
            $this->value = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value == null ? "print '{$this->string}'" : "print {$this->value}";
    }
}
