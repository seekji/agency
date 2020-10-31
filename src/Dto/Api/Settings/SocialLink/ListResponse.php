<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\SocialLink;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var SocialLink[]
     * @Type("array<App\Dto\Api\Settings\SocialLink\SocialLink>")
     */
    public ?array $socialLinks = [];

    public function __construct(?array $socialLinks = [])
    {
        foreach ($socialLinks as $socialLink) {
            $this->socialLinks[] = new SocialLink($socialLink);
        }
    }

}