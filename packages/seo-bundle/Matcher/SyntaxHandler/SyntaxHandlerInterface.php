<?php

namespace Seo\SeoBundle\Matcher\SyntaxHandler;

interface SyntaxHandlerInterface
{
    /**
     * @param string $pattern
     *
     * @return string
     */
    public function handle($pattern);
}
