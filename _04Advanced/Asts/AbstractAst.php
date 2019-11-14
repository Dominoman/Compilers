<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class AbstractAst
 * @package ACME\_04Advanced\Asts
 */
abstract class AbstractAst
{
    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    abstract public function compileMe(VMCreatorInterface $vmc);
}
