<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Psr7Bridge;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HttpMessageFactory implements HttpMessageFactoryInterface
{
    private $factory;

    public function __construct()
    {
        $this->factory = new PsrHttpFactory(...array_fill(0, 4, new Psr17Factory()));
    }

    /**
     * @param Request $symfonyRequest
     * @return ServerRequestInterface
     */
    public function createRequest(Request $symfonyRequest)
    {
        $psr7Request = $this->factory->createRequest($symfonyRequest);
        $baseUrl = $symfonyRequest->getBaseUrl();

        if (!$baseUrl) {
            return $psr7Request;
        }

        $uri = $psr7Request->getUri();
        $fixedUri = $uri->withPath(
            substr($uri->getPath(), strlen($baseUrl))
        );

        $psr7Request = $psr7Request->withUri($fixedUri);

        return $psr7Request;
    }

    /**
     * @param Response $symfonyResponse
     * @return ResponseInterface
     */
    public function createResponse(Response $symfonyResponse)
    {
        return $this->factory->createResponse($symfonyResponse);
    }
}
