<?php

namespace Seo\SeoBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Seo\SeoBundle\Entity\MetaData;
use Seo\SeoBundle\Metadata\CompiledMetadata;
use Seo\SeoBundle\Metadata\MetadataFactory;

class SEOExtension extends \Twig_Extension
{
    protected $requestStack;
    protected $metadataFactory;

    public function __construct(MetadataFactory $metadataFactory, RequestStack $requestStack)
    {
        $this->metadataFactory = $metadataFactory;
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('seo_extra', [$this, 'getExtra'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_title', [$this, 'renderTitle'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_meta_tags', [$this, 'renderMetaTags'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_load', [$this, 'getCompiledMetadata'], ['needs_context' => true]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'seo_extension';
    }

    /**
     * @param \Twig_Environment $environment
     * @param CompiledMetadata  $compiledMetadata
     *
     * @return string
     */
    public function renderMetaTags(\Twig_Environment $environment, CompiledMetadata $compiledMetadata = null)
    {
        if (!$compiledMetadata) {
            return null;
        }

        return $environment->render('SeoBundle:Metadata:tags.html.twig', [
            'tags' => $compiledMetadata->getMetaTags(),
            'compiledAt' => $compiledMetadata->getCompiledAt(),
        ]);
    }

    /**
     * @param CompiledMetadata $compiledMetadata
     * @param null             $postfix
     *
     * @return null|string
     */
    public function renderTitle(CompiledMetadata $compiledMetadata = null, $postfix = null)
    {
        if (!$compiledMetadata) {
            return null;
        }

        if (!$title = $compiledMetadata->getTitle()) {
            return null;
        }

        if ($postfix) {
            $title .= ' - '.$postfix;
        }

        return "<title>{$title}</title>";
    }

    /**
     * @param array $context
     * @param null  $url
     *
     * @return null|CompiledMetadata
     */
    public function getCompiledMetadata(array $context, $url = null)
    {
        return $this->metadataFactory->load($url ?: $this->requestStack->getCurrentRequest()->getUri(), $context);
    }

    /**
     * @param CompiledMetadata $compiledMetadata
     * @param $key
     *
     * @return array|null
     */
    public function getExtra(CompiledMetadata $compiledMetadata = null, $key)
    {
        if (!$compiledMetadata) {
            return null;
        }

        return $compiledMetadata->getExtraValue($key);
    }
}
