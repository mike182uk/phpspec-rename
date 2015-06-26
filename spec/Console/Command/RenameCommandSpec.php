<?php

namespace spec\Mdb\PhpSpecRenameExtension\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RenameCommandSpec extends ObjectBehavior
{
    function it_should_be_a_symfony_console_command()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
