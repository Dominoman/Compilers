<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class IfAst
 * @package ACME\_05Asm\Asts
 */
class IfAst extends AbstractCommand
{
    /**
     * @var AbstractAst
     */
    private $expr;

    /**
     * @var DoCommands
     */
    public $doTrue = null;

    /**
     * @var DoCommands
     */
    public $doFalse = null;

    /**
     * IfAst constructor.
     * @param AbstractAst $left
     */
    public function __construct(AbstractAst $left)
    {
        $this->expr = $left;
    }

    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $this->expr->compileMe($vmc);
        $iffalse = $vmc->allocateLabel("iffalse");
        $ifend = $vmc->allocateLabel("ifend");
        $vmc->createN0Jump($iffalse);
        $this->doTrue->compileMe($vmc);
        if ($this->doFalse != null) {
            $vmc->createJump($ifend);
        }
        $vmc->createLabel($iffalse);
        if ($this->doFalse != null) {
            $this->doFalse->compileMe($vmc);
            $vmc->createLabel($ifend);
        }
    }
}
