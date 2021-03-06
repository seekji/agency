<?php

declare(strict_types=1);

namespace App\Dto\Api\Technology;

use App\Dto\Api\Media\Media;
use JMS\Serializer\Annotation\Type;

class Technology
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
    public ?string $type;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $slug;

    /**
     * @Type("string")
     */
    public ?string $excerpt;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public ?Media $media = null;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?\App\Application\Sonata\MediaBundle\Entity\Media $detailPicture = null;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?\App\Application\Sonata\MediaBundle\Entity\Media $previewPicture = null;

    public function __construct(?\App\Entity\Technology $technology = null)
    {
        $this->id = $technology->getId();
        $this->title = $technology->getTitle();
        $this->sort = $technology->getSort();
        $this->slug = $technology->getSlug();
        $this->excerpt = $technology->getExcerpt();
        $this->type = \App\Entity\Technology::TYPES_LIST[$technology->getType()];

        if ($technology->getMedia() instanceof \App\Entity\Media) {
            $this->media = new Media($technology->getMedia());
        }

        if ($technology->getPicture() instanceof \App\Application\Sonata\MediaBundle\Entity\Media) {
            $this->detailPicture = $technology->getPicture();
        }

        if ($technology->getPreviewPicture() instanceof \App\Application\Sonata\MediaBundle\Entity\Media) {
            $this->previewPicture = $technology->getPreviewPicture();
        }

    }

}
