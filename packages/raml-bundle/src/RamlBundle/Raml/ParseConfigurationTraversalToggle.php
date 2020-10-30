<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Raml;

use Raml\ParseConfiguration;

class ParseConfigurationTraversalToggle extends ParseConfiguration
{
    /**
     * @param bool $allowDirectoryTraversal
     */
    public function __construct($allowDirectoryTraversal = false)
    {
        if ($allowDirectoryTraversal) {
            $this->enableDirectoryTraversal();
        }
    }
}
