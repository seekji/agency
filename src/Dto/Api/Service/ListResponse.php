<?php

declare(strict_types=1);

namespace App\Dto\Api\Service;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Service[]
     * @Type("array<App\Dto\Api\Service\Service>")
     */
    public array $services = [];

    public function __construct(?array $services = [])
    {
        foreach ($services as $service) {
            $this->services[] = new Service($service);
        }
    }
}
