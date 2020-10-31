<?php

declare(strict_types=1);

namespace App\Dto\Api\Video;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Video
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
    public ?string $href;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $picture = null;

    public function __construct(?\App\Entity\Video $video = null)
    {
        $this->id = $video->getId();
        $this->title = $video->getTitle();
        $this->href = $video->getHref();

        if ($video->getPicture() instanceof Media) {
            $this->picture = $video->getPicture();
        }
    }
}
