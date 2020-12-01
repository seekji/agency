<?php

declare(strict_types=1);

namespace App\Dto\Api\Technology;

use App\Dto\Api\Media\Media;
use App\Dto\Api\Settings\Achievement\Achievement;
use JMS\Serializer\Annotation\Type;

class TechnologyResponse
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("integer")
     */
    public ?int $sort;

    /**
     * @Type("string")
     */
    public ?string $type;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $slug;

    /**
     * @Type("string")
     */
    public ?string $excerpt;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public ?Media $previewPicture = null;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?\App\Application\Sonata\MediaBundle\Entity\Media $detailPicture = null;

    /**
     * @Type("array")
     */
    public ?array $blocks = null;

    /**
     * @Type("array")
     */
    public ?array $formattedBlocks = null;

    /**
     * @Type("string")
     */
    public ?string $AizekText = null;

    /**
     * @Type("string")
     */
    public ?string $AizekAchievementsTitle = null;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public ?Media $AizekPictureBlock = null;

    /**
     * @Type("array<App\Dto\Api\Media\Media>")
     */
    public ?array $AizekIcons = null;

    /**
     * @var Achievement[]
     * @Type("array<App\Dto\Api\Settings\Achievement\Achievement>")
     */
    public $AizekAchievements = null;

    /**
     * @Type("App\Dto\Api\Technology\Technology")
     */
    public $nextTechnology;

    public function __construct(?\App\Entity\Technology $technology = null, ?\App\Entity\Technology $nextTechnology = null)
    {
        $this->id = $technology->getId();
        $this->title = $technology->getTitle();
        $this->sort = $technology->getSort();
        $this->slug = $technology->getSlug();
        $this->excerpt = $technology->getExcerpt();
        $this->type = \App\Entity\Technology::TYPES_LIST[$technology->getType()];
        $this->AizekText = $technology->getAizekText();
        $this->AizekAchievementsTitle = $technology->getAizekAchievementsTitle();

        if ($technology->getMedia() instanceof \App\Entity\Media) {
            $this->previewPicture = new Media($technology->getMedia());
        }

        if ($technology->getAizekPictureBlock() instanceof \App\Entity\Media) {
            $this->AizekPictureBlock = new Media($technology->getAizekPictureBlock());
        }

        if ($technology->getAizekIcons()) {
            foreach ($technology->getAizekIcons() as $icon) {
                $this->AizekIcons[] = new Media($icon);
            }
        }

        if ($technology->getPicture() instanceof \App\Application\Sonata\MediaBundle\Entity\Media) {
            $this->detailPicture = $technology->getPicture();
        }

        if ($technology->getAizekAchievements()) {
            foreach ($technology->getAizekAchievements() as $achievement) {
                $this->AizekAchievements[] = new Achievement($achievement);
            }
        }

        if ($technology->getBlocks()) {
            foreach($technology->getBlocks() as $block) {
                $objectBlock = new Blocks($block);

                $this->blocks[] = $objectBlock;
                $this->formattedBlocks[$block->getGroupName()][] = $objectBlock;
            }
        }

        if ($nextTechnology) {
            $this->nextTechnology = new Technology($nextTechnology);
        }
    }

}
