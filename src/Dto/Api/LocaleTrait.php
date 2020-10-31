<?php

declare(strict_types=1);

namespace App\Dto\Api;

use App\Entity\Locale\LocaleInterface;

trait LocaleTrait
{
    /**
     * @Type("string")
     */
    public string $locale = LocaleInterface::LAN_RU;
}