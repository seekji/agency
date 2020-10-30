<?php
declare(strict_types = 1);

namespace Raml\RamlBundle\Listener;

use Raml\RamlBundle\RamlValidationException;
use Raml\RamlBundle\VndCustomRamlException;
use Psr\Http\Message\RequestInterface;
use Raml\Validator\RequestValidator;
use Raml\Validator\ResponseValidator;
use Raml\Validator\ValidatorRequestException;
use Raml\Validator\ValidatorResponseException;
use Raml\Validator\ValidatorSchemaException;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class SchemaValidationListener
{
    /**
     * @var HttpMessageFactoryInterface
     */
    private $messageFactory;
    /**
     * @var ResponseValidator
     */
    private $responseValidator;
    /**
     * @var RequestValidator
     */
    private $requestValidator;
    /**
     * @var string[]
     */
    private $excludeUrlPrefixes;
    /**
     * @var string[]
     */
    private $includeUrlPrefixes;

    /**
     * @var RequestInterface
     */
    private $psr7Request;

    public function __construct(
        HttpMessageFactoryInterface $factory,
        RequestValidator $requestValidator,
        ResponseValidator $responseValidator,
        array $excludeUrlPrefixes,
        array $includeUrlPrefixes
    ) {
        $this->messageFactory = $factory;
        $this->responseValidator = $responseValidator;
        $this->requestValidator = $requestValidator;
        $this->excludeUrlPrefixes = $excludeUrlPrefixes;
        $this->includeUrlPrefixes = $includeUrlPrefixes;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $url = $event->getRequest()->getPathInfo();
        $this->psr7Request = $this->messageFactory->createRequest($event->getRequest());
        if (!$this->isUrlIncluded($url) ||
            $this->isUrlExcluded($url) ||
            $this->requestValidator->getMethodSkipValidation($this->psr7Request)
        ) {
            return;
        }

        try {
            $this->requestValidator->validateRequest($this->psr7Request);
        } catch (\Exception $e) {
            if ($e instanceof ValidatorSchemaException
                || $e instanceof ValidatorRequestException
            ) {
                throw new BadRequestHttpException($e->getMessage());
            }

            throw new RamlValidationException($e->getMessage());
        }
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $url = $event->getRequest()->getPathInfo();
        if (!$this->psr7Request) {
            $this->psr7Request = $this->messageFactory->createRequest($event->getRequest());
        }
        if (!$this->isUrlIncluded($url) ||
            $this->isUrlExcluded($url) ||
            $this->requestValidator->getMethodSkipValidation($this->psr7Request)
        ) {
            return;
        }

        try {
            $this->validateEvent($event);
        } catch (ValidatorResponseException $e) {
            throw new RamlValidationException($e->getMessage());
        }
    }

    public function onKernelException(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $url = $event->getRequest()->getPathInfo();
        if (!$this->isUrlIncluded($url) || $this->isUrlExcluded($url)) {
            return;
        }

        $exception = $event->getException();

        if (!$exception instanceof VndCustomRamlException
            && !$exception instanceof HttpException
        ) {
            $event->setResponse(new Response(get_class($exception).': '.$exception->getMessage(), 500));

            return;
        }

        if ($exception instanceof HttpException) {
            $event->setResponse(
                new Response(
                    $exception->getMessage(),
                    $exception->getStatusCode(),
                    $exception->getHeaders()
                )
            );
        } else {
            $event->setResponse(
                new JsonResponse(
                    [
                        'message' => (string)$exception->getMessage(),
                        'code' => $exception->getErrorCode(),
                    ],
                    $exception->getHttpStatusCode(),
                    ['Content-type' => 'application/vnd.raml.error+json']
                )
            );
        }

        $this->validateEvent($event);
    }

    /**
     * @param KernelEvent $event
     */
    private function validateEvent(KernelEvent $event)
    {
        $psr7Request = $this->messageFactory->createRequest($event->getRequest());
        $psr7Response = $this->messageFactory->createResponse($event->getResponse());
        $psr7Response->getBody()->rewind();

        $this->responseValidator->validateResponse($psr7Request, $psr7Response);
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isUrlExcluded($url)
    {
        foreach ($this->excludeUrlPrefixes as $excludeUrlPrefix) {
            if (strpos($url, $excludeUrlPrefix) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isUrlIncluded($url)
    {
        if (empty($this->includeUrlPrefixes)) {
            return true;
        }

        foreach ($this->includeUrlPrefixes as $includeUrlPrefix) {
            if (strpos($url, $includeUrlPrefix) === 0) {
                return true;
            }
        }

        return false;
    }
}
