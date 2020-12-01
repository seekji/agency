<?php

declare(strict_types=1);

namespace App\Dto\Api\Technology;

use App\Dto\Api\Media\Media;
use JMS\Serializer\Annotation\Type;

class Blocks
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
    public ?string $groupName;

    /**
     * @Type("string")
     */
    public ?string $title;

    /**
     * @Type("string")
     */
    public ?string $text;

    /**
     * @Type("App\Application\Sonata\MediaBundle\Entity\Media")
     */
    public ?\App\Application\Sonata\MediaBundle\Entity\Media $picture = null;

    public function __construct(?\App\Entity\Technology\Blocks $block = null)
    {
        $this->id = $block->getId();
        $this->groupName = $block->getGroupName();
        $this->title = $block->getTitle();
        $this->sort = $block->getSort();
        $this->text = $block->getText();

        if ($block->getPicture() instanceof \App\Application\Sonata\MediaBundle\Entity\Media) {
            $this->picture = $block->getPicture();
        }
    }

}
