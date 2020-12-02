<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Seo\MetaRulesRequest;
use JMS\Serializer\SerializerInterface;
use Seo\SeoBundle\Service\SeoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/seo")
 */
class SeoController extends AbstractController
{
    private SeoService $seoService;
    private SerializerInterface $serializer;

    public function __construct(SeoService $seoService, SerializerInterface $serializer)
    {
        $this->seoService = $seoService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function tags(MetaRulesRequest $request): JsonResponse
    {
        $data = $this->seoService->getCompiledMetadataByRequest($request->url, $request->locale, $request->slug);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }
}