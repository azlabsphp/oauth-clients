<?php

use Drewlabs\AuthorizedClients\AuthorizedClientValidator;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\HttpSelector;
use Drewlabs\AuthorizedClients\Middleware\AuthorizedClients;
use Drewlabs\AuthorizedClients\Middleware\CreatesPsr7Request;
use Drewlabs\AuthorizedClients\Middleware\FirstPartyAuthorizedClients;
use Drewlabs\AuthorizedClients\Tests\HttpClientStub;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AuthorizedClientsMiddlewareTest extends TestCase
{
    private function createTestObject()
    {
        return new class {
            use CreatesPsr7Request;
        };
    }

    public function createSelector()
    {
        return HttpSelector::using(new HttpClientStub())->withCredentials('<CLIENT_ID>', '<CLIENT_SECRET>');
    }

    public function test_first_party_clients_middleware()
    {
        $middleware = new FirstPartyAuthorizedClients(new AuthorizedClientValidator($this->createSelector()));
        $psr7Request = $this->createTestObject()->psr7Request();
        $psr7Request = $psr7Request->withHeader('x-client-id', 'bdcf5a49-341e-4688-8bba-755237ecfaa1');
        $psr7Request = $psr7Request->withHeader('x-client-secret', '02afd968d07c308b6eda2fcf5915878a079f1bbf');
        $response = $middleware->handle($psr7Request, function($request) {
            return new Response();
        });
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function test_first_party_authorixed_clients_middleware_throws_exception()
    {
        $this->expectException(UnAuthorizedClientException::class);
        $middleware = new FirstPartyAuthorizedClients(new AuthorizedClientValidator($this->createSelector()));
        $psr7Request = $this->createTestObject()->psr7Request();
        $psr7Request = $psr7Request->withHeader('x-client-id', 'e28df7be-e9f7-4bd4-a689-c8a8d51afe96');
        $psr7Request = $psr7Request->withHeader('x-client-secret', '35a56ee81ae61f7464d4bffae812eafea2534c63');
        $middleware->handle($psr7Request, function($request) {
            return new Response();
        });
    }
    
    public function test_middleware_return_psr_response()
    {
        $middleware = new AuthorizedClients(new AuthorizedClientValidator($this->createSelector()));
        $psr7Request = $this->createTestObject()->psr7Request();
        $psr7Request = $psr7Request->withHeader('x-client-id', 'bdcf5a49-341e-4688-8bba-755237ecfaa1');
        $psr7Request = $psr7Request->withHeader('x-client-secret', '02afd968d07c308b6eda2fcf5915878a079f1bbf');
        $response = $middleware->handle($psr7Request, function($request) {
            return new Response();
        });
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function test_middleware_throws_exception_for_invalid_client()
    {
        $this->expectException(UnAuthorizedClientException::class);
        $middleware = new AuthorizedClients(new AuthorizedClientValidator($this->createSelector()));
        $psr7Request = $this->createTestObject()->psr7Request();
        $psr7Request = $psr7Request->withHeader('x-client-id', 'bdcf5a49-341e-4688-8bba-755237ecfaa1');
        $psr7Request = $psr7Request->withHeader('x-client-secret', '02afd968d07c308b6eda2fcf5915878a079f1f');
        $response = $middleware->handle($psr7Request, function($request) {
            return new Response();
        });
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function test_middleware_throws_exception_for_missing_scopes()
    {
        $this->expectException(UnAuthorizedClientException::class);
        $middleware = new AuthorizedClients(new AuthorizedClientValidator($this->createSelector()));
        $psr7Request = $this->createTestObject()->psr7Request();
        $psr7Request = $psr7Request->withHeader('x-client-id', 'e28df7be-e9f7-4bd4-a689-c8a8d51afe96');
        $psr7Request = $psr7Request->withHeader('x-client-secret', '35a56ee81ae61f7464d4bffae812eafea2534c63');
        $response = $middleware->handle($psr7Request, function($request) {
            return new Response();
        }, 'sys:all');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}