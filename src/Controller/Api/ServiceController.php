<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Service\ServiceRequest;
use App\Dto\Api\Service\ListRequest;
use App\Service\ServService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/services")
 */
class ServiceController extends AbstractController
{
    private ServService $servService;
    private SerializerInterface $serializer;

    public function __construct(ServService $servService, SerializerInterface $serializer)
    {
        $this->servService = $servService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function services(ListRequest $request): JsonResponse
    {
        $data = $this->servService->findServices($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

    /**
     * @Route("/{slug}", methods={"GET"})
     */
    public function service(ServiceRequest $request, string $slug): JsonResponse
    {
        $data = $this->servService->service($request, $slug);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }
}
