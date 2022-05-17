<?php

use Drewlabs\AuthorizedClients\Client;
use Drewlabs\AuthorizedClients\Tests\ClientsStub;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function test_client_constructor()
    {
        $attributes = array_values(array_filter(ClientsStub::getClients(), function($current) {
            return $current['id'] === 'bdcf5a49-341e-4688-8bba-755237ecfaa1';
        }))[0];
        $client = new Client($attributes);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }
}