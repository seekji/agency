<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\Settings\Translation\ListRequest;
use App\Service\SettingsService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/settings", methods={"GET"})
 */
class SettingsController extends AbstractController
{
    private SettingsService $settingsService;
    private SerializerInterface $serializer;

    public function __construct(SettingsService $settingsService, SerializerInterface $serializer)
    {
        $this->settingsService = $settingsService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function settings(\App\Dto\Api\Settings\ListRequest $request): Response
    {
        $data = $this->settingsService->getSettings($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

    /**
     * @Route("/translations", methods={"GET"})
     */
    public function translations(ListRequest $request): Response
    {
        $data = $this->settingsService->getTranslations($request);

        return new JsonResponse($this->serializer->serialize($data, 'json'), 200, [], true);
    }

}
