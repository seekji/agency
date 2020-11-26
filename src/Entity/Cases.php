<?php

declare(strict_types=1);

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media as SonataMedia;
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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CasesRepository::class)
 * @UniqueEntity(fields={"slug", "locale"}, message="slug.not_unique")
 */
class Cases implements SluggableInterface, TimestampableInterface, LocaleInterface
{
    use SluggableTrait, TimestampableTrait, LocaleTrait;

    public const RESULT_ACHIEVEMENT = 0;
    public const RESULT_OFFER = 1;

    public const RESULTS_LIST = [
        self::RESULT_OFFER => 'offer',
        self::RESULT_ACHIEVEMENT => 'achievement',
    ];

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
     * @Assert\NotBlank()
     */
    private ?SonataMedia $previewPicture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isItemBig = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isShowOnHomepage = true;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort = 0;

    /**
     * @ORM\Column(type="text")
     */
    private $taskTitle;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Assert\Count(
     *     max=4,
     *     maxMessage="achievements.count.max"
     * )
     */
    private $achievements = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $detailMedia;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tools;

    /**
     * @ORM\ManyToOne(targetEntity=Specialist::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialist;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Cases::class)
     */
    private $similarCase;

    /**
     * @ORM\OneToMany(targetEntity=CaseBlock::class, mappedBy="cases", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Orm\OrderBy({"sort" = "ASC"})
     * @Assert\NotBlank()
     * @Assert\Count(min=1, minMessage="case.blocks.count.min")
     */
    private $blocks;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $resultType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $runningTitle;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->blocks = new ArrayCollection();
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

    public function getPreviewPicture(): ?SonataMedia
    {
        return $this->previewPicture;
    }

    public function setPreviewPicture(?SonataMedia $media): self
    {
        $this->previewPicture = $media;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsItemBig(): ?bool
    {
        return $this->isItemBig;
    }

    public function setIsItemBig(bool $isItemBig): self
    {
        $this->isItemBig = $isItemBig;

        return $this;
    }

    public function getIsShowOnHomepage(): ?bool
    {
        return $this->isShowOnHomepage;
    }

    public function setIsShowOnHomepage(bool $isShowOnHomepage): self
    {
        $this->isShowOnHomepage = $isShowOnHomepage;

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

    public function getTaskTitle(): ?string
    {
        return $this->taskTitle;
    }

    public function setTaskTitle(string $taskTitle): self
    {
        $this->taskTitle = $taskTitle;

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

    public function getOffer(): ?string
    {
        return $this->offer;
    }

    public function setOffer(?string $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getDetailMedia(): ?Media
    {
        return $this->detailMedia;
    }

    public function setDetailMedia(?Media $detailMedia): self
    {
        $this->detailMedia = $detailMedia;

        return $this;
    }

    public function getTools(): ?string
    {
        return $this->tools;
    }

    public function setTools(?string $tools): self
    {
        $this->tools = $tools;

        return $this;
    }

    public function getSpecialist(): ?Specialist
    {
        return $this->specialist;
    }

    public function setSpecialist(?Specialist $specialist): self
    {
        $this->specialist = $specialist;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getSimilarCase(): ?self
    {
        return $this->similarCase;
    }

    public function setSimilarCase(?self $similarCase): self
    {
        $this->similarCase = $similarCase;

        return $this;
    }

    /**
     * @return Collection|CaseBlock[]
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(CaseBlock $block): self
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
            $block->setCases($this);
        }

        return $this;
    }

    public function removeBlock(CaseBlock $block): self
    {
        if ($this->blocks->removeElement($block)) {
            // set the owning side to null (unless already changed)
            if ($block->getCases() === $this) {
                $block->setCases(null);
            }
        }

        return $this;
    }

    public function getResultType(): ?int
    {
        return $this->resultType;
    }

    public function setResultType(?int $resultType): self
    {
        $this->resultType = $resultType;

        return $this;
    }

    public function getRunningTitle(): ?string
    {
        return $this->runningTitle;
    }

    public function setRunningTitle(?string $runningTitle): self
    {
        $this->runningTitle = $runningTitle;

        return $this;
    }
}
