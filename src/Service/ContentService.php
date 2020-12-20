<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ContentService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUniqueSlug($entity, $slug, $locale): string
    {
        $countEntities = 0;
        $entitySlug = $this->entityManager->createQueryBuilder()
            ->select('entity.slug')
            ->from($entity, 'entity')
            ->where('entity.slug LIKE :slug')
            ->andWhere('entity.locale = :locale')
            ->setParameter('locale', $locale)
            ->setParameter('slug', "{$slug}%")
            ->orderBy('entity.slug', 'DESC')
            ->andHaving('count(entity.slug) > 0')
            ->groupBy('entity.slug')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (isset($entitySlug[0]['slug']) && !empty($entitySlug[0]['slug'])) {
            $pieces = explode('-', $entitySlug[0]['slug']);
            $countEntities = intval(end($pieces)) + 1;
        }

        return $countEntities > 0 ? sprintf('%s-%d', $this->cleanSlug($slug), $countEntities) : $slug;
    }

    private function cleanSlug(string $slug): string
    {
        return preg_replace("/[^A-Za-z-]/", "", $slug);
    }
}
