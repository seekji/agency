<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Page\ListRequest;
use App\Dto\Api\Page\PageRequest;
use App\Service\PageService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/pages")
 */
class PageController extends AbstractController
{
    private PageService $pageService;
    private SerializerInterface $serializer;

    public function __construct(PageService $pageService, SerializerInterface $serializer)
    {
        $this->pageService = $pageService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function pages(ListRequest $request): Response
    {
        $data = $this->pageService->pages($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

    /**
     * @Route("/{slug}", methods={"GET"})
     */
    public function page(PageRequest $request, string $slug): Response
    {
        $data = $this->pageService->page($request, $slug);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }
}
