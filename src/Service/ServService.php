<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Service\ListRequest;
use App\Dto\Api\Service\ListResponse;
use App\Dto\Api\Service\ServiceRequest;
use App\Entity\Service;
use App\Repository\CasesRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServService
{
    public ServiceRepository $serviceRepository;
    public CasesRepository $caseRepository;

    public function __construct(ServiceRepository $serviceRepository, CasesRepository $casesRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->caseRepository = $casesRepository;
    }

    public function findServices(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->serviceRepository->findBy(['locale' => $request->locale], null, $request->limit, $request->offset));

        return $response;
    }

    public function service(ServiceRequest $request, string $slug): \App\Dto\Api\Service\Service
    {
        $service = $this->serviceRepository->findOneBy(['locale' => $request->locale, 'slug' => $slug]);

        if (!$service instanceof Service) {
            throw new NotFoundHttpException('Service not found', null, Response::HTTP_NOT_FOUND);
        }

        return new \App\Dto\Api\Service\Service($service);
    }
}
