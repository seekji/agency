<?php

declare(strict_types=1);

namespace App\Dto\Api\Partner;

use App\Dto\Api\LocaleTrait;
use JMS\Serializer\Annotation\Type;

class ListRequest
{
    use LocaleTrait;

    /**
     * @Type("integer")
     */
    public int $limit = 10;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

}