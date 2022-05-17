<?php

use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\HttpSelector;
use Drewlabs\AuthorizedClients\Tests\HttpClientStub;
use PHPUnit\Framework\TestCase;

class HttpSelectorTest extends TestCase
{
    public function test_invoke_return_instance_of_client()
    {
        $selector = new HttpSelector(new HttpClientStub);
        $client = $selector->__invoke('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf');
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }

    public function test_invoke_return_null()
    {
        $selector = new HttpSelector(new HttpClientStub);
        $client = $selector->__invoke('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1f');
        $this->assertNotInstanceOf(ClientInterface::class, $client);
        $this->assertNull($client);
    }
}