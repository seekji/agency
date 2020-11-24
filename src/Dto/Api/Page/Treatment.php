<?php

declare(strict_types=1);

namespace App\Dto\Api\Page;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Treatment
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
    public ?string $text;

    /**
     * @Type("integer")
     */
    public ?int $sort;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $picture = null;

    public function __construct(?\App\Entity\PageTreatments $pageTreatments = null)
    {
        $this->id = $pageTreatments->getId();
        $this->title = $pageTreatments->getTitle();
        $this->text = $pageTreatments->getText();
        $this->sort = $pageTreatments->getSort();

        if ($pageTreatments->getPicture() instanceof Media) {
            $this->picture = $pageTreatments->getPicture();
        }
    }
}
