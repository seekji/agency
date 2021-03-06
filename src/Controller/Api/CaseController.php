<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Cases\ItemRequest;
use App\Dto\Api\Cases\ListRequest;
use App\Service\CaseService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/cases")
 */
class CaseController extends AbstractController
{
    private CaseService $caseService;
    private SerializerInterface $serializer;

    public function __construct(CaseService $caseService, SerializerInterface $serializer)
    {
        $this->caseService = $caseService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET", "POST"})
     */
    public function cases(ListRequest $request): Response
    {
        $cases = $this->caseService->findCases($request);

        return new JsonResponse($this->serializer->serialize($cases, 'json'), 200, [], true);
    }

    /**
     * @Route("/{slug}", methods={"GET"})
     */
    public function item(ItemRequest $request, string $slug): Response
    {
        $response = $this->caseService->case($request, $slug);

        return new JsonResponse($this->serializer->serialize($response, 'json'), 200, [], true);
    }
}