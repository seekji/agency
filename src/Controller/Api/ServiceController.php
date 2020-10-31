<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Service\ListRequest;
use App\Service\ServService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/services")
 */
class ServiceController extends AbstractController
{
    private ServService $servService;

    public function __construct(ServService $servService)
    {
        $this->servService = $servService;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function services(ListRequest $request): Response
    {
        $services = $this->servService->findServices($request);

        return $this->json($services);
    }

}