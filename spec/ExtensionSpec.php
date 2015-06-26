<?php

namespace spec\Mdb\PhpSpecRenameExtension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionSpec extends ObjectBehavior
{
    function it_should_be_a_phpspec_extension()
    {
        $this->shouldHaveType('PhpSpec\Extension\ExtensionInterface');
    }
}
