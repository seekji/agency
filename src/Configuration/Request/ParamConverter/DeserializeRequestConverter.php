<?php

declare(strict_types=1);

namespace App\Configuration\Request\ParamConverter;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DeserializeRequestConverter extends BaseRequestConverter
{
    /** @var Serializer */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $object = $this->serializer->deserialize($request->getContent(), $configuration->getClass(), 'json');
        $request->attributes->set($configuration->getName(), $object);

        return true;
    }
}
