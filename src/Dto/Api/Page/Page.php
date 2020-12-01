<?php

declare(strict_types=1);

namespace App\Dto\Api\Page;

use JMS\Serializer\Annotation\Type;

class Page
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
    public ?string $slug;

    /**
     * @Type("string")
     */
    public string $type;

    /**
     * @Type("string")
     */
    public ?string $excerpt = null;

    public function __construct(?\App\Entity\Page $page = null)
    {
        $this->id = $page->getId();
        $this->title = $page->getTitle();
        $this->slug = $page->getSlug();
        $this->type = \App\Entity\Page::TYPE_LIST[$page->getType()];
        $this->excerpt = $page->getExcerpt();
    }
}
