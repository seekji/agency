<?php

declare(strict_types=1);

namespace App\Dto\Api\Media;

use App\Application\Sonata\MediaBundle\Entity\Media as SonataMedia;
use JMS\Serializer\Annotation\Type;

class Media
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $type;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?SonataMedia $file = null;

    public function __construct(?\App\Entity\Media $media = null)
    {
        $this->id = $media->getId();
        $this->title = $media->getTitle();
        $this->type = \App\Entity\Media::TYPE_LIST[$media->getType()];

        if ($media->getMedia() instanceof SonataMedia) {
            $this->file = $media->getMedia();
        }
    }
}
