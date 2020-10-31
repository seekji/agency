<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Translation;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Translation[]
     * @Type("array<App\Dto\Api\Settings\Translation\Translation>")
     */
    public ?array $translations = [];

    public function __construct(?array $translations = [])
    {
        foreach ($translations as $translation) {
            $this->translations[] = new Translation($translation);
        }
    }

}