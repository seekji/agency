<?php

declare(strict_types=1);

namespace App\Handler\Serializer;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\JsonSerializationVisitor;
use Sonata\MediaBundle\Provider\ImageProvider;
use Sonata\MediaBundle\Provider\FileProvider;
use Symfony\Component\Routing\RouterInterface;

class MediaSerializer
{
    private ImageProvider $imageProvider;
    private FileProvider $fileProvider;
    private RouterInterface $router;

    public function __construct(ImageProvider $imageProvider, FileProvider $fileProvider, RouterInterface $router)
    {
        $this->imageProvider = $imageProvider;
        $this->fileProvider = $fileProvider;
        $this->router = $router;
    }

    public function serializeEvent(JsonSerializationVisitor $visitor, Media $media)
    {
        $provider = $this->getProviderByName($media->getProviderName());

        return [
            'filename' => $media->getName(),
            'size' => sprintf("%.1f kB", $media->getSize() / 1000),
            'copyright' => $media->getCopyright(),
            'description' => $media->getDescription(),
            'src' => $this->$provider->generatePublicUrl($media, 'reference'),
            'height' => $media->getHeight(),
            'width' => $media->getWidth(),
            'context' => $media->getContext(),
            'id' => $media->getId(),
        ];
    }

    private function getProviderByName(string $provider): string
    {
        switch ($provider) {
            case 'sonata.media.provider.file':
            case 'sonata.media.provider.file.svg':
                return 'imageProvider';
                break;

            case 'sonata.media.provider.image':
                return 'fileProvider';
                break;

            default:
                throw new \RuntimeException("Serialization media provider not recognized.");
        }
    }
}
