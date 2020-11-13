<?php

namespace Seo\SeoBundle\Rule;

use Doctrine\ORM\EntityRepository;

class DoctrineRulesProvider implements RulesProviderInterface
{
    protected $em;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load()
    {
        return $this->repository->findBy([], ['priority' => 'DESC']);
    }
}
