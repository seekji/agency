<?php

namespace Seo\SeoBundle\Matcher;

use Seo\SeoBundle\Matcher\SyntaxHandler\AsteriskHandler;
use Seo\SeoBundle\Matcher\SyntaxHandler\SyntaxHandlerInterface;
use Seo\SeoBundle\Rule\RuleInterface;

class RuleMatcher
{
    /**
     * @var SyntaxHandlerInterface[]
     */
    protected $syntaxHandlers = [];

    public function __construct()
    {
        $this->syntaxHandlers[] = new AsteriskHandler();
    }

    /**
     * @param string          $path
     * @param RuleInterface[] $metadataCollection
     *
     * @return null|RuleInterface
     */
    public function match($path, $metadataCollection)
    {
        foreach ($metadataCollection as $metadata) {
            $pattern = preg_quote($metadata->getPattern(), '~');

            foreach ($this->syntaxHandlers as $handler) {
                $pattern = $handler->handle($pattern);
            }

            $pattern = '~\A'.$pattern.'\z~';

            if (preg_match($pattern, $path)) {
                return $metadata;
            }
        }

        return null;
    }
}
