<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Service\ListRequest;
use App\Dto\Api\Service\ListResponse;
use App\Repository\ServiceRepository;

class ServService
{
    public ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function findServices(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->serviceRepository->findBy([], null, $request->limit, $request->offset));

        return $response;
    }

}