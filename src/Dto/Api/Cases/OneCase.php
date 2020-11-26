<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Cases;
use App\Entity\Client;
use JMS\Serializer\Annotation\Type;

class OneCase
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
    public ?string $slug;

    /**
     * @Type("string")
     */
    public ?string $excerpt;

    /**
     * @Type("App\Dto\Api\Client\Client")
     */
    public $client;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $previewPicture = null;

    public function __construct(?Cases $case = null)
    {
        $this->id = $case->getId();
        $this->title = $case->getTitle();
        $this->slug = $case->getSlug();
        $this->excerpt = $case->getExcerpt();

        if ($case->getPreviewPicture() instanceof Media) {
            $this->previewPicture = $case->getPreviewPicture();
        }

        if ($case->getClient() instanceof Client) {
            $this->client = new \App\Dto\Api\Client\Client($case->getClient());
        }
    }
}
