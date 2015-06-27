<?php

namespace Mdb\PhpSpecRenameExtension;

use PhpSpec\Locator\ResourceInterface;

class ResourceContentModifier
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @param ResourceInterface $resource
     * @param string            $content
     */
    public function __construct(ResourceInterface $resource, $content)
    {
        $this->content = $content;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->content = preg_replace(
            sprintf('/namespace (%s|%s)/',
                preg_quote($this->resource->getSrcNamespace(), '/'),
                preg_quote($this->resource->getSpecNamespace(), '/')
            ),
            sprintf('namespace %s', $namespace),
            $this->content
        );
    }

    /**
     * @param $className
     */
    public function setClassName($className)
    {
        $this->content = preg_replace(
            sprintf('/class %s/', $this->resource->getName()),
            sprintf('class %s', $className),
            $this->content
        );
    }
}
