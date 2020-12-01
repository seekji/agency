<?php

declare(strict_types=1);

namespace App\Dto\Api\Technology;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Technology[]
     * @Type("array<App\Dto\Api\Technology\Technology>")
     */
    public array $technologies = [];

    /**
     * @Type("integer")
     */
    public int $limit = 50;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

    public function __construct(?array $technologies = [])
    {
        foreach ($technologies as $technology) {
            $this->technologies[] = new Technology($technology);
        }
    }

}
