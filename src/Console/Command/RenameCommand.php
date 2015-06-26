<?php

namespace Mdb\PhpSpecRenameExtension\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RenameCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rename')
            ->setDescription('Rename a class and its corresponding spec')
            ->addArgument('src', InputArgument::REQUIRED, 'src class')
            ->addArgument('target', InputArgument::REQUIRED, 'target class');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $src = $input->getArgument('src');
        $target = $input->getArgument('target');

        var_dump($src, $target);
    }
}
