<?php

namespace Seo\SeoBundle\Metadata\Compiler;

use Seo\SeoBundle\Metadata\CompiledMetadata;
use Seo\SeoBundle\Metadata\CompiledMetaTag;
use Seo\SeoBundle\Metadata\MetaTagInterface;
use Seo\SeoBundle\Rule\RuleInterface;

class Compiler implements CompilerInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function compileMetadata(RuleInterface $rule, array $context)
    {
        return new CompiledMetadata(
            $this->compileString($rule->getTitle(), $context),
            $this->compileMetaTags($rule->getMetaTags(), $context),
            $this->compileExtra($rule->getExtra(), $context)
        );
    }

    /**
     * @param MetaTagInterface[] $metaTags
     * @param array              $context
     *
     * @return array
     */
    protected function compileMetaTags(array $metaTags, array $context)
    {
        $compiledTags = [];

        foreach ($metaTags as $tag) {
            $compiledTags[] = new CompiledMetaTag($tag->getName(), $tag->getProperty(), $this->compileString($tag->getContent(), $context));
        }

        return $compiledTags;
    }

    /**
     * @param string $source
     * @param array  $context
     *
     * @return string
     */
    protected function compileString($source, array $context)
    {
        return $this->twig->createTemplate($source)->render($context);
    }

    /**
     * @param array $extra
     * @param array $context
     *
     * @return array
     */
    protected function compileExtra(array $extra, array $context)
    {
        return array_map(
            function ($data) use ($context) {
                return $this->compileString($data, $context);
            },
            $extra
        );
    }
}
