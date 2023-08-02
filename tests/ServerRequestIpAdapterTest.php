<?php

declare(strict_types=1);

/*
 * This file is part of the drewlabs namespace.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Drewlabs\Oauth\Clients\ServerRequestIpAdapter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;

class ServerRequestIpAdapterTest extends TestCase
{
    public function test_get_ip()
    {
        $request = $this->createServerRequest();
        $request = $request->withHeader('X-Real-Ip', '102.64.218.182');
        $adapter = new ServerRequestIpAdapter($request);
        $this->assertSame('102.64.218.182', $adapter->ip());
    }

    public function test_get_client_ip_from_server_global()
    {
        $psr17Factory = new Psr17Factory();
        $creator = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );
        $request = $creator->fromArrays([
            'REMOTE_ADDR' => '102.64.218.182',
            'REQUEST_METHOD' => 'GET',
        ]);
        $adapter = new ServerRequestIpAdapter($request);
        $this->assertSame('102.64.218.182', $adapter->ip());
    }

    private function createServerRequest()
    {
        $psr17Factory = new Psr17Factory();

        $psrHttpFactory = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        return $psrHttpFactory->fromGlobals();
    }
}
