<?php

namespace Seo\SeoBundle\Rule;

use Seo\SeoBundle\Metadata\MetaTagInterface;

interface RuleInterface
{
    /**
     * @return string
     */
    public function getEntity();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @return string
     */
    public function getPattern();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return MetaTagInterface[]
     */
    public function getMetaTags();

    /**
     * @return array
     */
    public function getExtra();
}
