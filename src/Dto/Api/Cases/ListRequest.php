<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use App\Dto\Api\LocaleTrait;
use JMS\Serializer\Annotation\Type;

class ListRequest
{
    use LocaleTrait;

    /**
     * @Type("integer")
     */
    public int $limit = 30;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

    /**
     * @Type("array")
     */
    public ?array $services;

    /**
     * @Type("array")
     */
    public ?array $branches;

    /**
     * @Type("bool")
     */
    public ?bool $isShowOnHomepage = null;

}