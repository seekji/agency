<?php

namespace Seo\SeoBundle\RedirectRule;

use Doctrine\ORM\EntityRepository;

class DoctrineRedirectRuleRepository extends EntityRepository implements RedirectRuleManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAllSortedByPriority()
    {
        return $this->findBy([], ['priority' => 'DESC']);
    }

    /**
     * {@inheritdoc}
     */
    public function save(RedirectRuleInterface $rule)
    {
        $em = $this->getEntityManager();
        $em->persist($rule);
        $em->flush($rule);
    }
}
