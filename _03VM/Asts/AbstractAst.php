<?php

declare(strict_types=1);

namespace ACME\_03VM\Asts;

use ACME\_03VM\VM\VMCreatorInterface;

/**
 * Class AbstractAst
 * @package ACME\_03VM\Asts
 */
abstract class AbstractAst
{
    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    abstract public function compileMe(VMCreatorInterface $vmc);
}
