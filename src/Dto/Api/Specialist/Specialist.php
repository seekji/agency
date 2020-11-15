<?php

declare(strict_types=1);

namespace App\Dto\Api\Specialist;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Specialist
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("string")
     */
    public ?string $name;

    /**
     * @Type("string")
     */
    public ?string $position;

    /**
     * @Type("string")
     */
    public ?string $quote;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $picture = null;

    public function __construct(?\App\Entity\Specialist $specialist = null)
    {
        $this->id = $specialist->getId();
        $this->name = $specialist->getName();
        $this->position = $specialist->getPosition();
        $this->quote = $specialist->getQuote();

        if ($specialist->getPicture() instanceof Media) {
            $this->picture = $specialist->getPicture();
        }
    }
}
