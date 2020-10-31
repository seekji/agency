<?php

declare(strict_types=1);

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Locale\LocaleInterface;
use App\Entity\Locale\LocaleTrait;
use App\Repository\CasesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=CasesRepository::class)
 */
class Cases implements SluggableInterface, TimestampableInterface, LocaleInterface
{
    use SluggableTrait, TimestampableTrait, LocaleTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class)
     */
    private ?Collection $services;

    /**
     * @ORM\ManyToOne(targetEntity=Branch::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Branch $branch;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $excerpt;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private ?Media $previewPicture;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): ?Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->services->removeElement($service);

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?: '';
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getPreviewPicture(): ?Media
    {
        return $this->previewPicture;
    }

    public function setPreviewPicture(?Media $media): self
    {
        $this->previewPicture = $media;

        return $this;
    }

    public function getSluggableFields(): array
    {
        return ['title'];
    }
}
