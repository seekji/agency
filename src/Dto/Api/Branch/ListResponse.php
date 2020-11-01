<?php

declare(strict_types=1);

namespace App\Dto\Api\Branch;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var Branch[]
     * @Type("array<App\Dto\Api\Branch\Branch>")
     */
    public array $branches = [];

    public function __construct(?array $branches = [])
    {
        foreach ($branches as $branch) {
            $this->branches[] = new Branch($branch);
        }
    }
}
