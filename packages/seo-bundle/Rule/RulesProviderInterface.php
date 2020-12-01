<?php

namespace Seo\SeoBundle\Rule;

interface RulesProviderInterface
{
    /**
     * @return RuleInterface[]
     */
    public function load();
}
