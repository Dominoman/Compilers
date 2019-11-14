<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class WhileAst
 * @package ACME\_04Advanced\Asts
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
     * @return mixed
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
