<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Controller;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

class ServiceLifeCycleController
{
    /**
     * @var string
     */
    private $ramlSchemaPath;
    /**
     * @var FileLocatorInterface
     */
    private $fileLocator;

    public function __construct(FileLocatorInterface $fileLocator, string $ramlSchemaPath)
    {
        $this->ramlSchemaPath = $ramlSchemaPath;
        $this->fileLocator = $fileLocator;
    }

    public function ramlAction() : Response
    {
        $file = new File($this->fileLocator->locate($this->ramlSchemaPath));

        return new BinaryFileResponse($file, 200, ['Content-Type' => 'application/raml+yaml']);
    }
}
