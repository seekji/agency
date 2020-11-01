<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Branch\ListRequest;
use App\Dto\Api\Branch\ListResponse;
use App\Repository\BranchRepository;

class BranchService
{
    public BranchRepository $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function find(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->branchRepository->findBy(['locale' => $request->locale], null, $request->limit, $request->offset));

        return $response;
    }

}