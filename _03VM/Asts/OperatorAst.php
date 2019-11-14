<?php

declare(strict_types=1);

namespace ACME\_03VM\Asts;

use ACME\_03VM\VM\VMCreatorInterface;
use ACME\_03VM\VM\VM;

/**
 * Class OperatorAst
 * @package ACME\_03VM\Asts
 */
class OperatorAst extends AbstractAst
{
    /**
     * @var string
     */
    public $operator;

    /**
     * @var AbstractAst
     */
    public $left;

    /**
     * @var AbstractAst
     */
    public $right;

    /**
     * OperatorAbstractAst constructor.
     * @param string $operator
     */
    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return "({$this->left}){$this->operator}({$this->right})";
    }


    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        $this->left->compileMe($vmc);
        $this->right->compileMe($vmc);
        switch ($this->operator) {
            case '+':
                $vmc->createOperator(VM::ADD);
                break;
            case '-':
                $vmc->createOperator(VM::SUB);
                break;
            case '*':
                $vmc->createOperator(VM::MUL);
                break;
            case '/':
                $vmc->createOperator(VM::DIV);
                break;
            case '%':
                $vmc->createOperator(VM::REM);
                break;
        }
    }
}
