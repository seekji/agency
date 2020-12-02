<?php

namespace Seo\SeoBundle\Entity;

use Seo\SeoBundle\Metadata\MetaTagInterface;
use Seo\SeoBundle\Rule\RuleInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity()
 * @ORM\Table(name="seo_rules")
 */
class Rule implements RuleInterface
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $pattern;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $locale = 'ru';

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    protected $metaTags = [];

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    protected $extra = [];

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority = 0;

    /**
     * Rule constructor.
     *
     * @param string $pattern
     * @param string $title
     * @param array  $metaTags
     * @param array  $extra
     */
    public function __construct($pattern = null, $title = null, $metaTags = [], $extra = [])
    {
        $this->pattern = $pattern;
        $this->title = $title;
        $this->metaTags = $metaTags;
        $this->extra = $extra;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     *
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return MetaTagInterface[]
     */
    public function getMetaTags()
    {
        return $this->metaTags;
    }

    /**
     * @param array $metaTags
     *
     * @return $this
     */
    public function setMetaTags($metaTags)
    {
        $this->metaTags = $metaTags;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     *
     * @return $this
     */
    public function setExtra(array $extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function setEntity(string $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }

}
