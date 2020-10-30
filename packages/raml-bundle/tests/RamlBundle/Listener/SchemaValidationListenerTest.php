<?php
declare(strict_types = 1);

namespace Raml\Tests\RamlBundle\Listener;

use Raml\RamlBundle\Listener\SchemaValidationListener;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Raml\Validator\RequestValidator;
use Raml\Validator\ResponseValidator;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Zend\Diactoros\ServerRequest;

class SchemaValidationListenerTest extends TestCase
{
    /**
     * @var HttpMessageFactoryInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $httpFactory;

    /**
     * @var RequestValidator|PHPUnit_Framework_MockObject_MockObject
     */
    private $requestValidator;

    /**
     * @var ResponseValidator|PHPUnit_Framework_MockObject_MockObject
     */
    private $responseValidator;

    public function setUp()
    {
        $this->httpFactory = $this->getMockBuilder(HttpMessageFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestValidator = $this->getMockBuilder(RequestValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->responseValidator = $this->getMockBuilder(ResponseValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider onKernelRequest_mustValidateRequestsWithSpecifiedPrefixes_DataProvider
     * @test
     */
    public function onKernelRequest_mustValidateRequestsWithSpecifiedPrefixes(array $includeUrlPrefixes, array $excludeUrlPrefixes, string $path) {
        $listener = $this->createListener($excludeUrlPrefixes, $includeUrlPrefixes);
        $event = $this->createGetResponseEvent($withPathInfo = $path);

        $this->requestValidator->expects($this->once())->method('validateRequest');

        $listener->onKernelRequest($event);
    }

    /**
     * @dataProvider onKernelRequest_dontMustValidateRequestsWithSpecifiedPrefixes_DataProvider
     * @test
     */
    public function onKernelRequest_dontMustValidateRequestsWithSpecifiedPrefixes(array $includeUrlPrefixes, array $excludeUrlPrefixes, string $path) {
        $listener = $this->createListener($excludeUrlPrefixes, $includeUrlPrefixes);
        $event = $this->createGetResponseEvent($withPathInfo = $path);

        $this->requestValidator->expects($this->never())->method('validateRequest');

        $listener->onKernelRequest($event);
    }

    public function onKernelRequest_mustValidateRequestsWithSpecifiedPrefixes_DataProvider()
    {
        return [
            'included and excluded url prefixes is not set, validate all requests, url: /' => [[], [], '/'],
            'included and excluded url prefixes is not set, validate all requests, url: /path' => [[], [], '/'],
            'included and excluded url prefixes is not set, validate all requests, url: /anotherpath' => [[], [], '/'],

            'root include prefix, validate all requests, url: /' => [['/'], [], '/'],
            'root include prefix, validate all requests, url: /path' => [['/'], [], '/path'],

            'include prefix is /path, validate url /path' => [['/path'], [], '/path'],
            'include prefix is /path, validate url /path/node' => [['/path'], [], '/path/node'],
            'include prefix is /path, validate url /path_two' => [['/path'], [], '/path/node'],

            'several include prefixes, validate url /path' => [['/path', '/anotherpath'], [], '/path'],
            'several include prefixes, validate url /anotherpath' => [['/path', '/anotherpath'], [], '/anotherpath'],

            'include prefix is not set, exclude prefix is /path, validate url /' => [[], ['/path'], '/'],
            'include prefix is not set, exclude prefix is /path, validate url /anotherpath' => [[], ['/path'], '/'],

            'several exclude prefixes, validate url /' => [[], ['/path', '/anotherpath'], '/'],

            'include prefix is /path, exclude prefix is /path/two, validate url /path/one' =>  [['/path'], ['/path/two'], '/path/one'],
        ];
    }

    public function onKernelRequest_dontMustValidateRequestsWithSpecifiedPrefixes_DataProvider()
    {
        return [
            'include prefix is /path, skip validation on url /' => [['/path'], [], '/'],
            'include prefix is /path, skip validation on url /anotherpath' => [['/path'], [], '/anotherpath'],

            'several include prefixes, skip validation on url /' => [['/path', '/anotherpath'], [], '/'],

            'include prefix is not set, exclude prefix is /path, skip validation on url /path' => [[], ['/path'], '/path'],
            'include prefix is not set, exclude prefix is /path, skip validation on url /path/node' => [[], ['/path'], '/path/node'],
            'include prefix is not set, exclude prefix is /path, skip validation on url /path_two' => [[], ['/path'], '/path_two'],

            'several exclude prefixes, skip validation on url /path' => [[], ['/path', '/anotherpath'], '/path'],
            'several exclude prefixes, skip validation on url /anotherpath' => [[], ['/path', '/anotherpath'], '/anotherpath'],

            'include prefix is /path, exclude prefix is /path/two, skip validation on url /path/two' => [['/path'], ['/path/two'], '/path/two'],
        ];
    }

    private function createListener(array $excluded, array $included)
    {
        return new SchemaValidationListener(
            $this->httpFactory,
            $this->requestValidator,
            $this->responseValidator,
            $excluded,
            $included
        );
    }

    private function createGetResponseEvent($pathInfo)
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->method('getPathInfo')->willReturn($pathInfo);
        $psr7request = new ServerRequest();
        $this->httpFactory->method('createRequest')->willReturn($psr7request);

        $event = $this->getMockBuilder(GetResponseEvent::class)
            ->disableOriginalConstructor()
            ->getMock();
        $event->method('isMasterRequest')->willReturn(true);
        $event->method('getRequest')->willReturn($request);

        return $event;
    }
}
