<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\SocialLink;

use JMS\Serializer\Annotation\Type;

class SocialLink
{
    /**
     * @Type("string")
     */
    public string $name;

    /**
     * @Type("string")
     */
    public string $link;

    public function __construct(array $socialLink)
    {
        $this->name = $socialLink['name'];
        $this->link = $socialLink['link'];
    }
}
