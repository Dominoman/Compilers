<?php

declare(strict_types=1);

namespace ACME\_04Advanced\Asts;

use ACME\_04Advanced\VM\VMCreatorInterface;

/**
 * Class DoCommands
 * @package ACME\_04Advanced\Asts
 */
class DoCommands extends AbstractCommand
{

    /**
     * @var AbstractCommand[]
     */
    private $commands = [];

    /**
     * @param AbstractCommand $command
     */
    public function addCommand(AbstractCommand $command): void
    {
        $this->commands[] = $command;
    }

    /**
     * @param VMCreatorInterface $vmc
     * @return mixed
     */
    public function compileMe(VMCreatorInterface $vmc): void
    {
        foreach ($this->commands as $command) {
            $command->compileMe($vmc);
        }
    }
}
