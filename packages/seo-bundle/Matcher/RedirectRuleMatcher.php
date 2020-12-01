<?php

namespace Seo\SeoBundle\Matcher;

use Seo\SeoBundle\Matcher\SyntaxHandler\AsteriskHandler;
use Seo\SeoBundle\Matcher\SyntaxHandler\SyntaxHandlerInterface;
use Seo\SeoBundle\RedirectRule\RedirectRuleInterface;

class RedirectRuleMatcher
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
     * @param string                  $path
     * @param RedirectRuleInterface[] $redirectRulesCollection
     *
     * @return null|RedirectRuleInterface
     */
    public function match($path, $redirectRulesCollection)
    {
        foreach ($redirectRulesCollection as $rule) {
            $pattern = preg_quote($rule->getSourceTemplate(), '~');

            foreach ($this->syntaxHandlers as $handler) {
                $pattern = $handler->handle($pattern);
            }

            $pattern = '~\A'.$pattern.'\z~';

            if (preg_match($pattern, $path)) {
                return $rule;
            }
        }

        return null;
    }
}
