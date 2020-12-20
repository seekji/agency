<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Locale\LocaleInterface;
use App\Entity\Locale\LocaleTrait;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page implements SluggableInterface, TimestampableInterface, LocaleInterface
{
    use SluggableTrait, LocaleTrait, TimestampableTrait;

    public const TYPE_TEXT = 0;
    public const TYPE_ABOUT = 1;
    public const TYPE_CONTACTS = 2;

    public const TYPE_LIST = [
        self::TYPE_TEXT => 'text',
        self::TYPE_ABOUT => 'about',
        self::TYPE_CONTACTS => 'contacts',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coordinates;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $achievements = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $history = [];

    /**
     * @ORM\ManyToMany(targetEntity=Specialist::class, cascade={"persist"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $specialists;

    /**
     * @ORM\OneToMany(targetEntity=PageTreatments::class, mappedBy="page", orphanRemoval=true, cascade={"persist"})
     */
    private $treatments;

    public function __construct()
    {
        $this->specialists = new ArrayCollection();
        $this->treatments = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSluggableFields(): array
    {
        return ['title'];
    }

    public function shouldRegenerateSlugOnUpdate(): bool
    {
        return false;
    }

    public function getCoordinates(): ?string
    {
        return $this->coordinates;
    }

    public function setCoordinates(?string $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAchievements(): ?array
    {
        return $this->achievements;
    }

    public function setAchievements(?array $achievements): self
    {
        $this->achievements = $achievements;

        return $this;
    }

    public function getHistory(): ?array
    {
        return $this->history;
    }

    public function setHistory(?array $history): self
    {
        $this->history = $history;

        return $this;
    }

    /**
     * @return Collection|Specialist[]
     */
    public function getSpecialists(): Collection
    {
        return $this->specialists;
    }

    public function addSpecialist(Specialist $specialist): self
    {
        if (!$this->specialists->contains($specialist)) {
            $this->specialists[] = $specialist;
        }

        return $this;
    }

    public function removeSpecialist(Specialist $specialist): self
    {
        $this->specialists->removeElement($specialist);

        return $this;
    }

    /**
     * @return Collection|PageTreatments[]
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(PageTreatments $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
            $treatment->setPage($this);
        }

        return $this;
    }

    public function removeTreatment(PageTreatments $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            // set the owning side to null (unless already changed)
            if ($treatment->getPage() === $this) {
                $treatment->setPage(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ? : '';
    }
}
