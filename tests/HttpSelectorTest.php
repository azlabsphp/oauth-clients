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

namespace Drewlabs\Oauth\Clients\Tests;

use Drewlabs\Oauth\Clients\Contracts\ClientInterface;
use Drewlabs\Oauth\Clients\Credentials;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class HttpSelectorTest extends TestCase
{
    public function test_invoke_return_instance_of_client()
    {
        $http = $this->createQueryClient();
        $client = $http->__invoke(new Credentials('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf'));
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }

    public function test_invoke_return_null()
    {
        $selector = $this->createQueryClient();
        $client = $selector->__invoke(new Credentials('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1f'));
        $this->assertNotInstanceOf(ClientInterface::class, $client);
        $this->assertNull($client);
    }

    private function createQueryClient()
    {
        $client = new HttpQueryClientStub(new HttpClientStub(), new Psr17Factory(), new Psr17Factory());

        $client
            ->setUrl('<LOCALHOST>')
            ->addHeader('x-client-id', '<CLIENT_ID>')
            ->addHeader('x-client-secret', '<CLIENT_SECRET>');

        return $client;
    }
}
