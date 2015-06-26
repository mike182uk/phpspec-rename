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
        $this->relocateSrc($oldResource, $newResource);
        $this->relocateSpec($oldResource, $newResource);
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     */
    private function relocateSrc(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $content = $this->modifySrcContent($oldResource, $newResource);

        $this->filesystem->remove($oldResource->getSrcFilename());

        $this->filesystem->dumpFile(
            $newResource->getSrcFilename(),
            $content
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     */
    private function relocateSpec(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $content = $this->modifySpecContent($oldResource, $newResource);

        $this->filesystem->remove($oldResource->getSpecFilename());

        $this->filesystem->dumpFile(
            $newResource->getSpecFilename(),
            $content
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     *
     * @return string
     */
    private function modifySrcContent(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $resourceContentModifier = new ResourceContentModifier(
            $oldResource,
            file_get_contents($oldResource->getSrcFilename())
        );

        $resourceContentModifier->setNamespace($newResource->getSrcNamespace());
        $resourceContentModifier->setClassName($newResource->getName());

        return $resourceContentModifier->getContent();
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     *
     * @return string
     */
    private function modifySpecContent(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $resourceContentModifier = new ResourceContentModifier(
            $oldResource,
            file_get_contents($oldResource->getSpecFilename())
        );

        $resourceContentModifier->setNamespace($newResource->getSrcNamespace());
        $resourceContentModifier->setClassName($newResource->getName());

        return $resourceContentModifier->getContent();
    }
}
