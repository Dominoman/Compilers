<?php

declare(strict_types=1);

namespace ACME\_03VM\Asts;

use ACME\_03VM\VM\VMCreatorInterface;

/**
 * Class ConstAst
 * @package ACME\_03VM\Asts
 */
class ConstAst extends AbstractAst
{
    /**
     * @var int
     */
    public $value;

    /**
     * ConstAbstractAst constructor.
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
