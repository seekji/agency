<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use App\Application\Sonata\MediaBundle\Entity\Media as SonataMedia;
use App\Dto\Api\Branch\Branch;
use App\Dto\Api\Client\Client;
use App\Dto\Api\Media\Media;
use App\Dto\Api\Service\Service;
use App\Dto\Api\Settings\Achievement\Achievement;
use App\Dto\Api\Specialist\Specialist;
use App\Entity\Cases;
use JMS\Serializer\Annotation\Type;

class FullCase
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $runningTitle = null;

    /**
     * @Type("string")
     */
    public ?string $slug;

    /**
     * @Type("string")
     */
    public ?string $excerpt;

    /**
     * @Type("string")
     */
    public ?string $tools;

    /**
     * @Type("string")
     */
    public ?string $offer = null;

    /**
     * @Type("string")
     */
    public ?string $taskTitle;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?SonataMedia $previewPicture = null;

    /**
     * @Type("App\Dto\Api\Branch\Branch")
     */
    public $branch;

    /**
     * @Type("array<App\Dto\Api\Service\Service>")
     */
    public $services;

    /**
     * @Type("App\Dto\Api\Cases\OneCase")
     */
    public $similarCase;

    /**
     * @Type("App\Dto\Api\Client\Client")
     */
    public $client;

    /**
     * @Type("App\Dto\Api\Specialist\Specialist")
     */
    public $specialist;

    /**
     * @var Achievement[]
     * @Type("array<App\Dto\Api\Settings\Achievement\Achievement>")
     */
    public $achievements = null;

    /**
     * @Type("array<App\Dto\Api\Cases\CaseBlock>")
     */
    public $blocks = null;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public ?Media $slideMedia = null;

    public function __construct(Cases $case = null)
    {
        $this->id = $case->getId();
        $this->title = $case->getTitle();
        $this->slug = $case->getSlug();
        $this->excerpt = $case->getExcerpt();
        $this->tools = $case->getTools();
        $this->taskTitle = $case->getTaskTitle();
        $this->runningTitle = $case->getRunningTitle();

        if ($case->getSpecialist()) {
            $this->specialist = new Specialist($case->getSpecialist());
        }

        if ($case->getClient()) {
            $this->client = new Client($case->getClient());
        }

        if ($case->getBranch()) {
            $this->branch = new Branch($case->getBranch());
        }

        if ($case->getBlocks()) {
            foreach ($case->getBlocks() as $block) {
                $this->blocks[] = new CaseBlock($block);
            }
        }

        if ($case->getSimilarCase() instanceof Cases) {
            $this->similarCase = new OneCase($case->getSimilarCase());
        }

        if ($case->getDetailMedia() instanceof \App\Entity\Media) {
            $this->slideMedia = new Media($case->getDetailMedia());
        }

        if ($case->getPreviewPicture() instanceof SonataMedia) {
            $this->previewPicture = $case->getPreviewPicture();
        }

        if ($case->getServices()) {
            foreach ($case->getServices() as $service) {
                $this->services[] = new Service($service);
            }
        }

        if ($case->getAchievements()) {
            foreach ($case->getAchievements() as $achievement) {
                $this->achievements[] = new Achievement($achievement);
            }
        } else {
            $this->offer = $case->getOffer();
        }
    }
}
