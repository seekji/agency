<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Translation;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @Type("array")
     */
    public ?array $translations = [];

    public function __construct(?array $translations = [])
    {
        foreach ($translations as $translation) {
            $translationObject = new Translation($translation);
            $this->translations[$translationObject->key] = $translationObject->translation;
        }
    }
}
