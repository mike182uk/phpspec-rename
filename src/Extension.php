<?php

namespace Mdb\PhpSpecRenameExtension;

use Mdb\PhpSpecRenameExtension\Console\Command\RenameCommand;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use Symfony\Component\Filesystem\Filesystem;

class Extension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ServiceContainer $container)
    {
        $container->setShared('locator.resource_relocator', function ($c) {
            return new ResourceRelocator(
                new Filesystem()
            );
        });

        $container->setShared('console.commands.rename', function ($c) {
            return new RenameCommand();
        });
    }
}
