<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Achievement;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Achievement[]
     * @Type("array<App\Dto\Api\Settings\Achievement\Achievement>")
     */
    public ?array $achievements = [];

    public function __construct(?array $achievements = [])
    {
        foreach ($achievements as $achievement) {
            $this->achievements[] = new Achievement($achievement);
        }
    }

}