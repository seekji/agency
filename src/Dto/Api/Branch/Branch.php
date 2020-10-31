<?php

declare(strict_types=1);

namespace App\Dto\Api\Branch;

use JMS\Serializer\Annotation\Type;

class Branch
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
    public ?string $title;

    public function __construct(?\App\Entity\Branch $branch = null)
    {
        $this->id = $branch->getId();
        $this->title = $branch->getTitle();
        $this->sort = $branch->getSort();
    }
}
