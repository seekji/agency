<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Technology\ListRequest;
use App\Dto\Api\Technology\ListResponse;
use App\Dto\Api\Technology\TechnologyRequest;
use App\Dto\Api\Technology\TechnologyResponse;
use App\Entity\Technology;
use App\Repository\TechnologyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TechnologyService
{
    public TechnologyRepository $technologyRepository;

    public function __construct(TechnologyRepository $technologyRepository)
    {
        $this->technologyRepository = $technologyRepository;
    }

    public function technologies(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->technologyRepository->findBy(['locale' => $request->locale, 'isActive' => true], ));

        $response->limit = $request->limit;
        $response->offset = $request->offset;

        return $response;
    }

    public function technology(TechnologyRequest $request, string $slug): TechnologyResponse
    {
        $technology = $this->technologyRepository->findOneBy(['locale' => $request->locale, 'slug' => $slug]);

        if (!$technology instanceof Technology) {
            throw new NotFoundHttpException('Technology not found', null, Response::HTTP_NOT_FOUND);
        }

        $nextTechnology = $this->getNextTechnology($technology);

        return new TechnologyResponse($technology, $nextTechnology);
    }

    private function getNextTechnology(Technology $technology)
    {
        return $this->technologyRepository->findNextTechnology($technology->getSort(), $technology->getLocale(), [$technology->getId()]);
    }

}
