<?php

namespace Seo\SeoBundle\Service;

use Seo\SeoBundle\Metadata\MetadataFactory;

class SeoService
{
    public $metadataFactory;

    public function __construct(MetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
    }

    public function getCompiledMetadataByRequest(string $url, string $locale, string $slug = null)
    {
        return $this->metadataFactory->load($url, ['needs_context' => true], $locale, $slug);
    }
}
