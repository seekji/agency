<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Achievement;

use JMS\Serializer\Annotation\Type;

class Achievement
{
    /**
     * @Type("integer")
     */
    public int $count;

    /**
     * @Type("string")
     */
    public string $countType;

    /**
     * @Type("string")
     */
    public string $title;

    /**
     * @Type("string")
     */
    public string $description;

    public function __construct(array $achievement)
    {
        $this->count = $achievement['count'];
        $this->countType = $achievement['count_type'];
        $this->title = $achievement['title'];
        $this->description = $achievement['description'];
    }
}
