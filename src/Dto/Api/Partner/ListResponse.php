<?php

declare(strict_types=1);

namespace App\Dto\Api\Partner;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Partner[]
     * @Type("array<App\Dto\Api\Partner\Partner>")
     */
    public array $partners = [];

    public function __construct(?array $partners = [])
    {
        foreach ($partners as $partner) {
            $this->partners[] = new Partner($partner);
        }
    }
}
