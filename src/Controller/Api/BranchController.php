<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Branch\ListRequest;
use App\Service\BranchService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/branches")
 */
class BranchController extends AbstractController
{
    private BranchService $branchService;
    private SerializerInterface $serializer;

    public function __construct(BranchService $branchService, SerializerInterface $serializer)
    {
        $this->branchService = $branchService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function cases(ListRequest $request): Response
    {
        $branches = $this->branchService->find($request);

        return new JsonResponse($this->serializer->serialize($branches, 'json'), 200, [], true);
    }
}
