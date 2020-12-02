<?php

declare(strict_types=1);

namespace App\Dto\Api\Seo;

use App\Dto\Api\LocaleTrait;
use JMS\Serializer\Annotation\Type;

class MetaRulesRequest
{
    use LocaleTrait;

    /**
     * @Type("string")
     */
    public string $url;

    /**
     * @Type("string")
     */
    public ?string $slug = null;
}
