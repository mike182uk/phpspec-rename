<?php

namespace spec\Mdb\PhpSpecRenameExtension;

use PhpSpec\Locator\ResourceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceContentModifierSpec extends ObjectBehavior
{
    const CONTENT = <<<EOF
<?php

namespace Foo;

class Bar
{

}
EOF;

    function let(ResourceInterface $resource)
    {
        $resource->getSrcNamespace()->willReturn('Foo');
        $resource->getSpecNamespace()->willReturn('spec/Foo');
        $resource->getName()->willReturn('Bar');

        $this->beConstructedWith($resource, self::CONTENT);
    }

    function it_should_expose_the_modified_content()
    {
        $this->getContent()->shouldReturn(self::CONTENT);
    }

    function it_should_modify_the_namespace()
    {
        $this->setNamespace('Bar');

        $this->getContent()->shouldMatch('/namespace Bar/');
    }

    function it_should_modify_the_class_name()
    {
        $this->setClassName('Baz');

        $this->getContent()->shouldMatch('/class Baz/');
    }
}
