<?php

namespace Seo\SeoBundle\Model;

use Seo\SeoBundle\Metadata\MetaTagInterface;

class MetaTag implements MetaTagInterface
{

    protected $name;
    protected $property;
    protected $content;

    public function __construct($name = null, $property = null, $content = null)
    {
        $this->name = $name;
        $this->property = $property;
        $this->content = $content;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function getContent()
    {
        return $this->content;
    }
}
