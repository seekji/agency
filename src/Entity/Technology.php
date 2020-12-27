<?php

declare(strict_types=1);

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media as SonataMedia;
use App\Entity\Locale\LocaleInterface;
use App\Entity\Locale\LocaleTrait;
use App\Entity\Technology\Blocks;
use App\Repository\TechnologyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TechnologyRepository::class)
 */
class Technology implements TimestampableInterface, LocaleInterface, SluggableInterface
{
    use TimestampableTrait, LocaleTrait, SluggableTrait;

    public const TYPE_DEFAULT = 0;
    public const TYPE_AIZEK = 1;

    public const TYPES_LIST = [
        self::TYPE_DEFAULT => 'default',
        self::TYPE_AIZEK => 'aizek'
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
     * @ORM\Column(type="text")
     */
    private $excerpt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $media;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $AizekText;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $AizekAchievements = [];

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $AizekPictureBlock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AizekAchievementsTitle;

    /**
     * @ORM\OneToMany(targetEntity=Blocks::class, mappedBy="technology", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Orm\OrderBy({"sort" = "ASC"})
     * @Assert\NotBlank()
     * @Assert\Count(min=1, minMessage="technology.blocks.count.min")
     */
    private $blocks;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="technology", orphanRemoval=true, cascade={"persist"})
     */
    private $AizekIcons;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private ?SonataMedia $picture;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private ?SonataMedia $previewPicture;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->AizekIcons = new ArrayCollection();
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(string $excerpt): self
    {
        $this->excerpt = $excerpt;

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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ? : '';
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getAizekText(): ?string
    {
        return $this->AizekText;
    }

    public function setAizekText(?string $AizekText): self
    {
        $this->AizekText = $AizekText;

        return $this;
    }

    public function getAizekAchievements(): ?array
    {
        return $this->AizekAchievements;
    }

    public function setAizekAchievements(?array $AizekAchievements): self
    {
        $this->AizekAchievements = $AizekAchievements;

        return $this;
    }

    public function getAizekPictureBlock(): ?Media
    {
        return $this->AizekPictureBlock;
    }

    public function setAizekPictureBlock(?Media $AizekPictureBlock): self
    {
        $this->AizekPictureBlock = $AizekPictureBlock;

        return $this;
    }

    public function getAizekAchievementsTitle(): ?string
    {
        return $this->AizekAchievementsTitle;
    }

    public function setAizekAchievementsTitle(?string $AizekAchievementsTitle): self
    {
        $this->AizekAchievementsTitle = $AizekAchievementsTitle;

        return $this;
    }

    /**
     * @return Collection|Blocks[]
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(Blocks $block): self
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
            $block->setTechnology($this);
        }

        return $this;
    }

    public function removeBlock(Blocks $block): self
    {
        if ($this->blocks->removeElement($block)) {
            // set the owning side to null (unless already changed)
            if ($block->getTechnology() === $this) {
                $block->setTechnology(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getAizekIcons(): Collection
    {
        return $this->AizekIcons;
    }

    public function addAizekIcon(Media $aizekIcon): self
    {
        if (!$this->AizekIcons->contains($aizekIcon)) {
            $this->AizekIcons[] = $aizekIcon;
            $aizekIcon->setTechnology($this);
        }

        return $this;
    }

    public function removeAizekIcon(Media $aizekIcon): self
    {
        if ($this->AizekIcons->removeElement($aizekIcon)) {
            // set the owning side to null (unless already changed)
            if ($aizekIcon->getTechnology() === $this) {
                $aizekIcon->setTechnology(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?SonataMedia
    {
        return $this->picture;
    }

    public function setPicture(?SonataMedia $media): self
    {
        $this->picture = $media;

        return $this;
    }

    public function getPreviewPicture(): ?SonataMedia
    {
        return $this->previewPicture;
    }

    public function setPreviewPicture(?SonataMedia $media): self
    {
        $this->previewPicture = $media;

        return $this;
    }

    public function __clone()
    {
        $blocks = $this->getBlocks();
        $this->blocks = new ArrayCollection();

        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $clonedBlock = clone $block;
                $this->blocks->add($clonedBlock);
                $clonedBlock->setTechnology($this);
            }
        }

        $aizekIcons = $this->getAizekIcons();
        $this->AizekIcons = new ArrayCollection();

        if (count($aizekIcons) > 0) {
            foreach ($aizekIcons as $icon) {
                $clonedIcon = clone $icon;
                $this->AizekIcons->add($clonedIcon);
                $clonedIcon->setTechnology($this);
            }
        }
    }
}
