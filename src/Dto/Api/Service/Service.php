<?php

declare(strict_types=1);

namespace App\Dto\Api\Service;

use App\Dto\Api\Media\Media;
use JMS\Serializer\Annotation\Type;

class Service
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("integer")
     */
    public ?int $sort;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $slug;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public Media $media;

    public function __construct(?\App\Entity\Service $service = null)
    {
        $this->id = $service->getId();
        $this->title = $service->getTitle();
        $this->sort = $service->getSort();
        $this->slug = $service->getSlug();

        if ($service->getMedia() instanceof \App\Entity\Media) {
            $this->media = new Media($service->getMedia());
        }
    }
}
