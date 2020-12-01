<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Seo\SeoBundle\Metadata\CompiledMetadata;
use Seo\SeoBundle\Metadata\MetadataFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/seo")
 */
class SeoController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function tags()
    {
        $factory = $this->container->get('seo.metadata_factory');

       dd($factory);
    }
}