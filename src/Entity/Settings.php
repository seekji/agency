<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Locale\LocaleInterface;
use App\Entity\Locale\LocaleTrait;
use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings implements TimestampableInterface, LocaleInterface
{
    use TimestampableTrait, LocaleTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="json")
     */
    private ?array $translations = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $privacy;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $terms;

    /**
     * @ORM\Column(type="json")
     */
    private ?array $achievements = [];

    /**
     * @ORM\ManyToOne(targetEntity=Video::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Video $video;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $socialLinks = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $menuLinks = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTranslations(): ?array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): self
    {
        $this->translations = $translations;

        return $this;
    }

    public function __toString(): string
    {
        return $this->locale ? : '';
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPrivacy(): ?string
    {
        return $this->privacy;
    }

    public function setPrivacy(?string $privacy): self
    {
        $this->privacy = $privacy;

        return $this;
    }

    public function getTerms(): ?string
    {
        return $this->terms;
    }

    public function setTerms(?string $terms): self
    {
        $this->terms = $terms;

        return $this;
    }

    public function getAchievements(): ?array
    {
        return $this->achievements;
    }

    public function setAchievements(array $achievements): self
    {
        $this->achievements = $achievements;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(Video $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getSocialLinks(): ?array
    {
        return $this->socialLinks;
    }

    public function setSocialLinks(?array $socialLinks): self
    {
        $this->socialLinks = $socialLinks;

        return $this;
    }

    public function getMenuLinks(): ?array
    {
        return $this->menuLinks;
    }

    public function setMenuLinks(?array $menuLinks): self
    {
        $this->menuLinks = $menuLinks;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
