<?php

namespace Seo\SeoBundle\Matcher\SyntaxHandler;

class AsteriskHandler implements SyntaxHandlerInterface
{
    /**
     * @param string $pattern
     *
     * @return string
     */
    public function handle($pattern)
    {
        return str_replace('\{\*\}', '.*', $pattern);
    }
}
