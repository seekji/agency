<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Page\ListRequest;
use App\Dto\Api\Page\ListResponse;
use App\Dto\Api\Page\PageRequest;
use App\Dto\Api\Page\PageResponse;
use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageService
{
    public PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function pages(ListRequest $request): ListResponse
    {
        $response = new ListResponse($this->pageRepository->findBy(['locale' => $request->locale, 'isPublished' => true], null, $request->limit, $request->offset));

        $response->limit = $request->limit;
        $response->offset = $request->offset;

        return $response;
    }

    public function page(PageRequest $request, string $slug): PageResponse
    {
        $page = $this->pageRepository->findOneBy(['isPublished' => true, 'locale' => $request->locale, 'slug' => $slug]);

        if (!$page instanceof Page) {
            throw new NotFoundHttpException('Page not found');
        }

        return new PageResponse($page);
    }
}
