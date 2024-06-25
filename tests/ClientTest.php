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

use Drewlabs\Oauth\Clients\Client;
use Drewlabs\Oauth\Clients\Tests\ClientsStub;
use Drewlabs\Oauth\Clients\Tests\Stubs\AttributeAwareMockFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    use AttributeAwareMockFactory;

    public function test_client_constructor()
    {
        $attributes = array_values(array_filter(ClientsStub::getClients(), static function ($current) {
            return 'bdcf5a49-341e-4688-8bba-755237ecfaa1' === $current['id'];
        }))[0];
        $client = new Client($this->createAttributeAware($attributes));
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }


    public function test_client_get_api_key_returns_api_key_value_from_attributes()
    {
        // Initialize
        $attributes = array_values(array_filter(ClientsStub::getClients(), static function ($current) {
            return 'bdcf5a49-341e-4688-8bba-755237ecfaa1' === $current['id'];
        }))[0];

        $apiKey = sprintf("k_%s", base64_encode(bin2hex(random_bytes(15))));
        $attributes['api_key'] = $apiKey;

        // Act
        $client = new Client($this->createAttributeAware($attributes));

        // Assert
        $this->assertEquals($apiKey, $client->getApiKey());
    }
}
