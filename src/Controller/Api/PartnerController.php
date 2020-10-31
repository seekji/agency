<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Partner\ListRequest;
use App\Service\PartnerService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/partners")
 */
class PartnerController extends AbstractController
{
    private PartnerService $partnerService;
    private SerializerInterface $serializer;

    public function __construct(PartnerService $partnerService, SerializerInterface $serializer)
    {
        $this->partnerService = $partnerService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function cases(ListRequest $request): Response
    {
        $data = $this->partnerService->findPartners($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

}