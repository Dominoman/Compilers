<?php

declare(strict_types=1);

namespace ACME\_03VM;

use ACME\_03VM\Asts\AbstractAst;
use ACME\_03VM\Asts\ConstAst;
use ACME\_03VM\Asts\OperatorAst;
use ACME\_03VM\Asts\PrintAst;
use ACME\_03VM\Asts\SetAst;
use ACME\_03VM\Asts\VariableAst;
use Exception;

/**
 * Class ScriptParser
 * @package ACME\_VM
 */
class ScriptParser extends Parser
{

    /**
     * ScriptParser constructor.
     * @param AbstractLexer $input
     */
    public function __construct(AbstractLexer $input)
    {
        parent::__construct($input);
    }

    /**
     * @return AbstractAst|null
     * @throws Exception
     */
    public function parse(): ?AbstractAst
    {
        if ($this->la(1) == Token::TTEOF) {
            return null;
        }
        if ($this->la(1) == Token::TTID && $this->la(2) == ord('=')) {
            $variable = $this->lt(1)->getValue();
            $this->consume();
            $this->consume();
            $command = new SetAst($variable, $this->parseExpression());
            $this->match(ord(';'));
            return $command;
        }
        if ($this->la(1) == Token::TTPRINT) {
            $this->consume();
            if ($this->la(1) == Token::TTSTRING) {
                $command = new PrintAst($this->lt(1)->getValue());
                $this->consume();
                $this->match(ord(';'));
                return $command;
            }
            $command = new PrintAst($this->parseExpression());
            $this->match(ord(';'));
            return $command;
        }
        throw new Exception("Syntax error! {$this->lt(1)}");
    }

    /**
     * @return AbstractAst
     * @throws Exception
     */
    private function parseExpression(): AbstractAst
    {
        return $this->parseAddSub();
    }

    /**
     * @return AbstractAst
     * @throws Exception
     */
    private function parseAddSub(): AbstractAst
    {
        $op1 = $this->parseMulDiv();
        while ($this->la(1) == ord('+') || $this->la(1) == ord('-')) {
            $operator = new OperatorAst(chr($this->la(1)));
            $this->consume();
            $operator->left = $op1;
            $operator->right = $this->parseMulDiv();
            $op1 = $operator;
        }
        return $op1;
    }

    /**
     * @return AbstractAst
     * @throws Exception
     */
    private function parseMulDiv(): AbstractAst
    {
        $op1 = $this->parseFactor();
        while ($this->la(1) == ord('*') || $this->la(1) == ord('/') || $this->la(1) == ord('%')) {
            $operator = new OperatorAst(chr($this->la(1)));
            $this->consume();
            $operator->left = $op1;
            $operator->right = $this->parseFactor();
            $op1 = $operator;
        }
        return $op1;
    }

    /**
     * @return AbstractAst
     * @throws Exception
     */
    private function parseFactor(): AbstractAst
    {
        if ($this->la(1) == ord('-')) {
            $this->consume();
            $operator = new OperatorAst('-');
            $operator->left = new ConstAst(0);
            $operator->right = $this->parseFactor();
            return $operator;
        }
        if ($this->la(1) == Token::TTNUMBER) {
            /** @var int $value */
            $value = $this->lt(1)->getValue();
            $this->consume();
            return new ConstAst($value);
        }
        if ($this->la(1) == ord('(')) {
            $this->consume();
            $subexpression = $this->parseExpression();
            $this->match(ord(')'));
            return $subexpression;
        }
        if ($this->la(1) == Token::TTID) {
            $variable = $this->lt(1)->getValue();
            $this->consume();
            return new VariableAst($variable);
        }
        throw new Exception("Syntax error! {$this->lt(1)}");
    }
}
