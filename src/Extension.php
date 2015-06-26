<?php

namespace Mdb\PhpSpecRenameExtension;

use Mdb\PhpSpecRenameExtension\Console\Command\RenameCommand;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class Extension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->setShared('console.commands.rename', function ($c) {
            return new RenameCommand();
        });
    }
}
