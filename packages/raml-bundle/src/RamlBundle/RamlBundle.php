<?php
declare(strict_types = 1);

namespace Raml\RamlBundle;

use Raml\RamlBundle\DependencyInjection\ServiceExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RamlBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ServiceExtension();
    }
}
