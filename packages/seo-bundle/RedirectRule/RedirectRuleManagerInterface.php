<?php

namespace Seo\SeoBundle\RedirectRule;

interface RedirectRuleManagerInterface
{
    /**
     * @return RedirectRuleInterface[]
     */
    public function findAllSortedByPriority();

    /**
     * @param RedirectRuleInterface $rule
     */
    public function save(RedirectRuleInterface $rule);
}
