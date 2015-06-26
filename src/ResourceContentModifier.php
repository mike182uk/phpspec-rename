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
     * @param string $content
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
            sprintf('/%s/', $this->resource->getSrcNamespace()),
            $namespace,
            $this->content
        );
    }

    /**
     * @param $className
     */
    public function setClassName($className)
    {
        $this->content = preg_replace(
            sprintf('/%s/', $this->resource->getName()),
            $className,
            $this->content
        );
    }
}
