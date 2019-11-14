<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class AbstractAst
 * @package ACME\_05Asm\Asts
 */
abstract class AbstractAst
{
    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    abstract public function compileMe(VMCreatorInterface $vmc);
}
