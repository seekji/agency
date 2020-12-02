<?php

namespace Seo\SeoBundle\Metadata\Compiler;

use Doctrine\ORM\EntityManagerInterface;
use Seo\SeoBundle\Metadata\CompiledMetadata;
use Seo\SeoBundle\Metadata\CompiledMetaTag;
use Seo\SeoBundle\Metadata\MetaTagInterface;
use Seo\SeoBundle\Rule\RuleInterface;

class CompilerByEntity implements CompilerInterface
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function compileMetadata(RuleInterface $rule, array $context)
    {
        $entity = null;

        if ($context['slug'] !== null && $context['locale'] !== null) {
            $entity = $this->findEntity($context['slug'], $context['locale'], $rule->getEntity());
        }

        return new CompiledMetadata(
            $this->compileString($rule->getTitle(), $context, $entity),
            $this->compileMetaTags($rule->getMetaTags(), $context, $entity),
            $this->compileExtra($rule->getExtra(), $context, $entity)
        );
    }

    protected function compileMetaTags(array $metaTags, array $context, $entity = null)
    {
        $compiledTags = [];

        foreach ($metaTags as $tag) {
            $compiledTags[] = new CompiledMetaTag($tag['name'], $tag['property'], $this->compileString($tag['content'], $context, $entity));
        }

        return $compiledTags;
    }

    protected function compileString($source, array $context, $entity = null)
    {
        if ($entity) {
            preg_match_all('/\{\{(.*?)\}\}/', $source, $matches, PREG_PATTERN_ORDER);

            if ($matches) {
                foreach($matches[0] as $key => $variableToReplace) {
                    $method = $matches[1][$key];
                    $source = str_replace($variableToReplace, $entity->$method(), $source);
                }
            }
        }

        return $source;
    }

    protected function compileExtra(array $extra, array $context, $entity = null)
    {
        return array_map(
            function ($data) use ($context, $entity) {
                return $this->compileString($data, $context, $entity);
            },
            $extra
        );
    }

    private function findEntity(string $slug, string $locale, string $entity)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('entity')
            ->from($entity, 'entity')
            ->where('entity.slug = :slug')
            ->andWhere('entity.locale = :locale')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
