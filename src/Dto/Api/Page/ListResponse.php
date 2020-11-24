<?php

declare(strict_types=1);

namespace App\Dto\Api\Page;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Page[]
     * @Type("array<App\Dto\Api\Page\Page>")
     */
    public array $pages = [];

    /**
     * @Type("integer")
     */
    public int $limit = 30;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

    public function __construct(?array $pages = [])
    {
        foreach ($pages as $page) {
            $this->pages[] = new Page($page);
        }
    }
}
