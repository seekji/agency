<?php

namespace App\Entity\Locale;

trait LocaleTrait
{
    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $locale;

    public function setLocale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
}