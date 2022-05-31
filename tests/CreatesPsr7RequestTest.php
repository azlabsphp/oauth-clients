<?php

use Drewlabs\AuthorizedClients\Middleware\CreatesPsr7Request;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class CreatesPsr7RequestTest extends TestCase
{
    private function createTestObject()
    {
        return new class {
            use CreatesPsr7Request;
        };
    }


    public function test_create_psr7_request()
    {
        $request = $this->createTestObject()->psr7Request();
        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('GET', $request->getMethod());
    }

    public function test_get_ip()
    {
        $object = $this->createTestObject();
        $request = $object->psr7Request();
        $request = $request->withHeader('X-Real-Ip', '102.64.218.182');
        $ip_addr = $object->ip($request);
        $this->assertEquals('102.64.218.182', $ip_addr);
    }

    public function test_get_client_ip_from_server_global()
    {
        $object = $this->createTestObject();
        $psr17Factory = new Psr17Factory();
        $creator = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );
        $request = $creator->fromArrays([
            'REMOTE_ADDR' => '102.64.218.182',
            'REQUEST_METHOD' => 'GET'
        ]);
        $ip_addr = $object->ip($request);
        $this->assertEquals('102.64.218.182', $ip_addr);
    }
}