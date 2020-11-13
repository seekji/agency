<?php

namespace Seo\SeoBundle\Metadata\Compiler;

use Seo\SeoBundle\Metadata\CompiledMetadata;
use Seo\SeoBundle\Rule\RuleInterface;

interface CompilerInterface
{
    /**
     * @param RuleInterface $rule
     * @param array         $context
     *
     * @return CompiledMetadata
     */
    public function compileMetadata(RuleInterface $rule, array $context);
}
