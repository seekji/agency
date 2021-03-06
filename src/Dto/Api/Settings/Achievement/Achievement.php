<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Achievement;

use JMS\Serializer\Annotation\Type;

class Achievement
{
    /**
     * @Type("string")
     */
    public string $count;

    /**
     * @Type("string")
     */
    public ?string $countType;

    /**
     * @Type("string")
     */
    public ?string $title = null;

    /**
     * @Type("string")
     */
    public string $description;

    public function __construct(array $achievement)
    {
        $this->count = (string) $achievement['count'];
        $this->countType = $achievement['count_type'] ? : null;
        $this->title = isset($achievement['title']) ? $achievement['title'] : null;
        $this->description = $achievement['description'];
    }
}
