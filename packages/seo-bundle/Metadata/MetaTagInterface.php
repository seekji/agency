<?php

namespace Seo\SeoBundle\Metadata;

interface MetaTagInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getProperty();

    /**
     * @return string
     */
    public function getContent();
}
