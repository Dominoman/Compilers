<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class ConstAst
 * @package ACME\_05Asm\Asts
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


    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $vmc->pushInt($this->value);
    }
}
