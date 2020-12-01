<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Technology\ListRequest;
use App\Dto\Api\Technology\TechnologyRequest;
use App\Service\TechnologyService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/technologies", methods={"GET"})
 */
class TechnologyController extends AbstractController
{
    private TechnologyService $technologyService;
    private SerializerInterface $serializer;

    public function __construct(TechnologyService $technologyService, SerializerInterface $serializer)
    {
        $this->technologyService = $technologyService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function technologies(ListRequest $request): Response
    {
        $data = $this->technologyService->technologies($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

    /**
     * @Route("/{slug}", methods={"GET"})
     */
    public function translations(TechnologyRequest $request, string $slug): Response
    {
        $data = $this->technologyService->technology($request, $slug);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }
}
