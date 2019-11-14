<?php

declare(strict_types=1);

namespace ACME\_05Asm\Asts;

use ACME\_05Asm\VM\VMCreatorInterface;

/**
 * Class DoCommands
 * @package ACME\_05Asm\Asts
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
