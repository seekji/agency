<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Api\Settings\Translation\ListRequest;
use App\Dto\Api\Settings\Translation\ListResponse;
use App\Dto\Api\Settings\ListResponse as SettingsListResponse;
use App\Dto\Api\Settings\ListRequest as SettingsListRequest;
use App\Repository\SettingsRepository;

class SettingsService
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function getSettings(SettingsListRequest $request): SettingsListResponse
    {
        $settings = $this->settingsRepository->findOneBy(['locale' => $request->locale]);
        $response = new SettingsListResponse($settings);

        return $response;
    }

    public function getTranslations(ListRequest $request): ListResponse
    {
        $settings = $this->settingsRepository->findOneBy(['locale' => $request->locale]);

        $response = new ListResponse($settings->getTranslations());

        return $response;
    }

}