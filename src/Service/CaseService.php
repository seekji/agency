<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Cases\FullCase;
use App\Dto\Api\Cases\ItemRequest;
use App\Dto\Api\Cases\ListRequest;
use App\Dto\Api\Cases\ListResponse;
use App\Entity\Cases;
use App\Repository\CasesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CaseService
{
    public CasesRepository $caseRepository;

    public function __construct(CasesRepository $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    public function findCases(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->caseRepository->findByRequest($request));

        $response->limit = $request->limit;
        $response->offset = $request->offset;

        return $response;
    }

    public function case(ItemRequest $request, string $slug): FullCase
    {
        $case = $this->caseRepository->findOneBy(['isActive' => true, 'locale' => $request->locale, 'slug' => $slug]);

        if (!$case instanceof Cases) {
            throw new NotFoundHttpException('Case not found', null, Response::HTTP_NOT_FOUND);
        }

        return new FullCase($case);
    }
}
