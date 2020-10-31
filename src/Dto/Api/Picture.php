<?php

declare(strict_types=1);

namespace App\Dto\Api;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Picture
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("string")
     */
    public ?string $path;

    /**
     * @Type("string")
     */
    public ?string $filename;

    /**
     * @Type("string")
     */
    public ?string $description;

    /**
     * @Type("integer")
     */
    public ?int $size;

    public function __construct(?Media $media = null)
    {
        $this->id = $media->getId();
        $this->filename = $media->getName();
        $this->description = $media->getDescription();
        $this->size = $media->getSize();
        $this->path = $media->getProviderName();
    }
}
