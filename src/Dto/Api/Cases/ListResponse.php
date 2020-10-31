<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use JMS\Serializer\Annotation\Type;

class ListResponse
{
    /**
     * @var OneCase[]
     * @Type("array<App\Dto\Api\Cases\OneCase>")
     */
    public array $cases = [];

    /**
     * @Type("integer")
     */
    public int $limit = 10;

    /**
     * @Type("integer")
     */
    public int $offset = 0;

    public function __construct(?array $cases = [])
    {
        foreach ($cases as $case) {
            $this->cases[] = new OneCase($case);
        }
    }
}
