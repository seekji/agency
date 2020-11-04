<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media as SonataMedia;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media implements TimestampableInterface
{
    use TimestampableTrait;

    public const TYPE_VIDEO = 0;
    public const TYPE_PICTURE = 1;
    public const TYPE_HREF = 2;

    public const TYPE_LIST = [
        self::TYPE_VIDEO => 'Video',
        self::TYPE_PICTURE => 'Picture',
        self::TYPE_HREF => 'Link'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $href;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private ?SonataMedia $media;

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

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getMedia(): ?SonataMedia
    {
        return $this->media;
    }

    public function setMedia(?SonataMedia $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?: '';
    }
}
