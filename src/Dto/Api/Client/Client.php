<?php

declare(strict_types=1);

namespace App\Dto\Api\Client;

use App\Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\Annotation\Type;

class Client
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
    public ?string $about;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?Media $picture = null;

    public function __construct(?\App\Entity\Client $client = null)
    {
        $this->id = $client->getId();
        $this->name = $client->getName();
        $this->about = $client->getAbout();

        if ($client->getPicture() instanceof Media) {
            $this->picture = $client->getPicture();
        }
    }
}
