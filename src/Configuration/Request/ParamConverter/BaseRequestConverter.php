<?php

declare(strict_types=1);

namespace App\Configuration\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

abstract class BaseRequestConverter implements ParamConverterInterface
{
    public function supports(ParamConverter $configuration): bool
    {
        if (!$class = $configuration->getClass()) {
            return false;
        }

        if (strpos($class, 'App\Dto\Api') !== 0) {
            return false;
        }

        if (substr($class, -7) !== 'Request') {
            return false;
        }

        return true;
    }
}
