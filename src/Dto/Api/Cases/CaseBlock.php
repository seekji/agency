<?php

declare(strict_types=1);

namespace App\Dto\Api\Cases;

use App\Dto\Api\Media\Media;
use JMS\Serializer\Annotation\Type;

class CaseBlock
{
    /**
     * @Type("integer")
     */
    public ?int $id;

    /**
     * @Type("string")
     */
    public ?string $text = null;

    /**
     * @Type("integer")
     */
    public ?int $type;

    /**
     * @Type("App\Dto\Api\Media\Media")
     */
    public ?Media $media = null;

    public function __construct(\App\Entity\CaseBlock $caseBlock)
    {
        $this->id = $caseBlock->getId();
        $this->text = $caseBlock->getText();
        $this->type = $caseBlock->getType();

        if ($caseBlock->getMedia() instanceof \App\Entity\Media) {
            $this->media = new Media($caseBlock->getMedia());
        }
    }
}
