<?php

declare(strict_types=1);

namespace App\Dto\Api\Partner;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Partner
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
    public ?string $name;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $picture = null;

    public function __construct(?\App\Entity\Partner $partner = null)
    {
        $this->id = $partner->getId();
        $this->name = $partner->getName();
        $this->sort = $partner->getSort();

        if ($partner->getPicture() instanceof Media) {
            $this->picture = $partner->getPicture();
        }
    }
}
