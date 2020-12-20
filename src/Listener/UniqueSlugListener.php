<?php

declare(strict_types=1);

namespace App\Listener;

use App\Service\ContentService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UniqueSlugListener
{
    private ContentService $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!method_exists($entity, 'getSlug')) {
            return;
        }

        $entity->setSlug($this->contentService->createUniqueSlug(get_class($entity), $entity->getSlug(), $entity->getLocale()));
    }
}
