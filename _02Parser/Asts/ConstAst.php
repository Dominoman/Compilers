<?php

declare(strict_types=1);

namespace ACME\_02Parser\Asts;

/**
 * Class ConstAst
 * @package ACME\_02Parser\Asts
 */
class ConstAst extends AbstractAst
{
    /**
     * @var int
     */
    public $value;

    /**
     * ConstAst constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return strval($this->value);
    }
}
