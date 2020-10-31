<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Cases\ListRequest;
use App\Dto\Api\Cases\ListResponse;
use App\Repository\CasesRepository;

class CaseService
{
    public CasesRepository $caseRepository;

    public function __construct(CasesRepository $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    public function findCases(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->caseRepository->findBy(['locale' => $request->locale], null, $request->limit, $request->offset));

        $response->limit = $request->limit;
        $response->offset = $request->offset;

        return $response;
    }

}