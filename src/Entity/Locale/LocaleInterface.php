<?php

namespace App\Entity\Locale;

interface LocaleInterface
{
    public const LAN_EN = 'en';
    public const LAN_RU = 'ru';

    public const LOCALE_LIST = [
        self::LAN_RU => 'Руc',
        self::LAN_EN => 'En'
    ];

    public function setLocale(string $locale);

    public function getLocale(): ?string;
}