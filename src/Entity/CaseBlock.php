<?php

namespace App\Entity;

use App\Repository\CaseBlockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaseBlockRepository::class)
 */
class CaseBlock
{
    public const TYPE_TEXT = 0;
    public const TYPE_MEDIA = 1;

    public const TYPES_LIST = [
        self::TYPE_TEXT  => 'text',
        self::TYPE_MEDIA => 'media'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity=Cases::class, inversedBy="blocks", cascade={"persist"})
     */
    private $cases;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
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

    public function getCases(): ?Cases
    {
        return $this->cases;
    }

    public function setCases(?Cases $cases): self
    {
        $this->cases = $cases;

        return $this;
    }
}
