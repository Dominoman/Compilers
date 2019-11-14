<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class WhileAst
 * @package ACME\_05Asm\Asts
 */
class WhileAst extends AbstractCommand
{
    /**
     * @var AbstractAst
     */
    private $expr;

    /**
     * @var AbstractCommand
     */
    public $do = null;

    /**
     * WhileAst constructor.
     * @param AbstractAst $expr
     */
    public function __construct(AbstractAst $expr)
    {
        $this->expr = $expr;
    }


    /**
     * @param VMCreatorInterface $vmc
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $wbegin = $vmc->allocateLabel("whilebegin");
        $wend = $vmc->allocateLabel("whileend");
        $vmc->createLabel($wbegin);
        $this->expr->compileMe($vmc);
        $vmc->createN0Jump($wend);
        $this->do->compileMe($vmc);
        $vmc->createJump($wbegin);
        $vmc->createLabel($wend);
    }
}
