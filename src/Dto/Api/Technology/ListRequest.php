<?php

declare(strict_types=1);

namespace App\Dto\Api\Technology;

use App\Dto\Api\LocaleTrait;
use JMS\Serializer\Annotation\Type;

class ListRequest
{
    use LocaleTrait;

    /**
     * @Type("integer")
     */
    public int $limit = 50;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

}
