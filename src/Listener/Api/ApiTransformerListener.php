<?php

declare(strict_types=1);

namespace App\Listener\Api;

use Raml\RamlBundle\RamlValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiTransformerListener
{
    private $env;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    public function onKernelException(ExceptionEvent $event): void
    {

        $request = $event->getRequest();

        if (stristr($request->getRequestUri(), 'admin')) {
            return;
        }

        $exception = $event->getThrowable();
        $message = $exception->getMessage();

        switch (true) {
            case $exception instanceof HttpException:
                $statusCode = $exception->getStatusCode();
                break;
            case $exception instanceof AccessDeniedHttpException:
                $statusCode = Response::HTTP_FORBIDDEN;
                break;
            case $exception instanceof RamlValidationException:
                $statusCode = Response::HTTP_BAD_REQUEST;
                break;
            default:
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $this->env === 'prod' ? 'Internal error' : $exception->getMessage();
        }

        $response = new JsonResponse(
            [
                'code' => $exception->getCode(),
                'message' => $message,
            ],
            $statusCode
        );

        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_UNESCAPED_UNICODE);

        $event->setResponse($response);
    }
}
