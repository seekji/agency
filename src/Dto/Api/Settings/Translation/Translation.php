<?php

declare(strict_types=1);

namespace App\Dto\Api\Settings\Translation;

use JMS\Serializer\Annotation\Type;

class Translation
{
    /**
     * @Type("string")
     */
    public string $key;

    /**
     * @Type("string")
     */
    public string $translation;

    public function __construct(array $translation)
    {
        $this->key = $translation['key'];
        $this->translation = $translation['translation'];
    }
}
