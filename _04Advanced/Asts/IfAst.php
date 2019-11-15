<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class IfAst
 * @package ACME\_04Advanced\Asts
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
        $vmc->createJump0($iffalse);
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
