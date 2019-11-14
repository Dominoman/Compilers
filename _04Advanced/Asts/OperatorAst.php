<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;
use ACME\_04Advanced\VM\VM;

/**
 * Class OperatorAst
 * @package ACME\_04Advanced\Asts
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
     * OperatorAst constructor.
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
            case '<':
                $vmc->createOperator(VM::LESS);
                break;
            case '=':
                $vmc->createOperator(VM::EQ);
                break;
            case '>':
                $vmc->createOperator(VM::GREATER);
                break;
            case '&':
                $vmc->createOperator(VM::AND);
                break;
            case '|':
                $vmc->createOperator(VM::OR);
                break;
        }
    }
}
