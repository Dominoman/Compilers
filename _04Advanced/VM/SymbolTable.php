<?php

declare(strict_types=1);

namespace ACME\_04Advanced\VM;

/**
 * Class SymbolTable
 * @package ACME\_04Advanced\VM
 */
class SymbolTable
{
    /**
     * @var array
     */
    private $dictionary = [];

    /**
     * @var int
     */
    private $start = 0;

    /**
     * SymbolTable constructor.
     * @param int $start
     */
    public function __construct(int $start)
    {
        $this->start = $start;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getVariable(string $name): int
    {
        if (!key_exists($name, $this->dictionary)) {
            $this->dictionary[$name] = $this->start++;
        }
        return $this->dictionary[$name];
    }
}
