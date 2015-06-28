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
        $this->relocateResource(
            $oldResource->getSrcFilename(),
            $newResource->getSrcFilename(),
            $this->modifySrcContent($oldResource, $newResource)
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     */
    private function relocateSpec(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        $this->relocateResource(
            $oldResource->getSpecFilename(),
            $newResource->getSpecFilename(),
            $this->modifySpecContent($oldResource, $newResource)
        );
    }

    /**
     * @param string $oldFilename
     * @param string $newFilename
     * @param string $newContents
     */
    private function relocateResource($oldFilename, $newFilename, $newContents)
    {
        $this->filesystem->remove($oldFilename);

        $this->filesystem->dumpFile(
            $newFilename,
            $newContents
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
        return $this->modifyResourceContent(
            $oldResource,
            file_get_contents($oldResource->getSrcFilename()),
            $newResource->getSrcNamespace(),
            $newResource->getName()
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param ResourceInterface $newResource
     *
     * @return string
     */
    private function modifySpecContent(ResourceInterface $oldResource, ResourceInterface $newResource)
    {
        return $this->modifyResourceContent(
            $oldResource,
            file_get_contents($oldResource->getSpecFilename()),
            $newResource->getSpecNamespace(),
            $newResource->getName()
        );
    }

    /**
     * @param ResourceInterface $oldResource
     * @param string            $content
     * @param string            $newNamespace
     * @param string            $newClassName
     *
     * @return string
     */
    private function modifyResourceContent(ResourceInterface $oldResource, $content, $newNamespace, $newClassName)
    {
        $resourceContentModifier = new ResourceContentModifier($oldResource, $content);

        $resourceContentModifier->setNamespace($newNamespace);
        $resourceContentModifier->setClassName($newClassName);

        return $resourceContentModifier->getContent();
    }
}
