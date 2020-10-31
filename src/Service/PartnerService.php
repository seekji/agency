<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Partner\ListRequest;
use App\Dto\Api\Partner\ListResponse;
use App\Repository\PartnerRepository;

class PartnerService
{
    public PartnerRepository $partnerService;

    public function __construct(PartnerRepository $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function findPartners(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->partnerService->findBy(['locale' => $request->locale, 'isActive' => true], null, $request->limit, $request->offset));

        return $response;
    }

}