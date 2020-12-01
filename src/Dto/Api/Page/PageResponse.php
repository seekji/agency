<?php

declare(strict_types=1);

namespace App\Dto\Api\Page;

use App\Dto\Api\Specialist\Specialist;
use JMS\Serializer\Annotation\Type;

class PageResponse
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
    public string $slug;

    /**
     * @Type("string")
     */
    public string $type;

    /**
     * @Type("string")
     */
    public ?string $coordinates = null;

    /**
     * @Type("string")
     */
    public ?string $excerpt = null;

     /**
      * @Type("string")
      */
    public ?string $description = null;

    /**
     * @Type("array")
     */
    public ?array $achievements = null;

    /**
     * @Type("array")
     */
    public ?array $history = null;

    /**
     * @Type("array<App\Dto\Api\Specialist\Specialist>")
     */
    public ?array $specialists = null;

    /**
     * @Type("array<App\Dto\Api\Page\Treatment>")
     */
    public ?array $treatments = null;

    public function __construct(\App\Entity\Page $page)
    {
        $this->id = $page->getId();
        $this->title = $page->getTitle();
        $this->slug = $page->getSlug();
        $this->type = \App\Entity\Page::TYPE_LIST[$page->getType()];
        $this->achievements = $page->getAchievements();
        $this->coordinates = $page->getCoordinates();
        $this->description = $page->getDescription();
        $this->history = $page->getHistory();
        $this->excerpt = $page->getExcerpt();

        if ($page->getSpecialists()) {
            foreach ($page->getSpecialists() as $specialist) {
                $this->specialists[] = new Specialist($specialist);
            }
        }

        if ($page->getTreatments()) {
            foreach ($page->getTreatments() as $treatment) {
                $this->treatments[] = new Treatment($treatment);
            }
        }
    }
}
