<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use App\Dto\Api\LocaleTrait;
use JMS\Serializer\Annotation\Type;

class ItemRequest
{
    use LocaleTrait;

    /**
     * @Type("integer")
     */
    public string $slug;
}
