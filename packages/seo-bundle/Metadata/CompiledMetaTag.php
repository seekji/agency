<?php

namespace Seo\SeoBundle\Metadata;

class CompiledMetaTag
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $property;

    /**
     * @var string
     */
    public $content;

    /**
     * @param $name
     * @param $property
     * @param $content
     */
    public function __construct($name, $property, $content)
    {
        $this->name = $name;
        $this->property = $property;
        $this->content = $content;
    }
}
