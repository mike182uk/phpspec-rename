<?php

namespace Mdb\PhpSpecRenameExtension;

use PhpSpec\Locator\ResourceInterface;
use Symfony\Component\Filesystem\Filesystem;

class ResourceRelocator
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     */
    public function relocate(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $content = $this->modifyResourceContent($oldResource, $newResource);

        $this->filesystem->remove($oldResource->getSrcFilename());

        $this->filesystem->dumpFile(
            $newResource->getSrcFilename(),
            $content
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     *
     * @return string
     */
    private function modifyResourceContent(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $resourceContentModifier = new ResourceContentModifier(
            $oldResource,
            file_get_contents($oldResource->getSrcFilename())
        );

        $resourceContentModifier->setNamespace($newResource->getSrcNamespace());
        $resourceContentModifier->setClassName($newResource->getName());

        return $resourceContentModifier->getContent();
    }
}
