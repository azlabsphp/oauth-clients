<?php

use Drewlabs\Oauth\Clients\NewClient;
use PHPUnit\Framework\TestCase;

class NewClientTest extends TestCase
{

    public function test_new_client_set_name_set_name_property_value()
    {
        // Act
        $client = (new NewClient)->setName('Test Client');

        // Assert
        $this->assertEquals('Test Client', $client->getName());
    }


    public function test_new_client_set_user_id_property_value()
    {
        // Initialize
        $client = (new NewClient)->setName(null);

        // Assert
        $this->assertEquals(null, $client->getUserId());

        // Act
        $client = $client->setUserId((string)1297);

        // Assert
        $this->assertEquals('1297', $client->getUserId());
    }

    public function test_new_client_set_redirect_url_property_value()
    {
        // Act
        $client = (new NewClient)->setRedirectUrl('https://api.micronaut.app');

        // Assert
        $this->assertEquals('https://api.micronaut.app', $client->getRedirectUrl());
    }

    public function test_new_client_set_provider_property_value()
    {
        // Act
        $client = (new NewClient)->setProvider('drewlabs:jwt');

        // Assert
        $this->assertEquals('drewlabs:jwt', $client->getProvider());
    }

    
    public function test_new_client_set_ip_addresses_property_value()
    {
        // Act
        $client = (new NewClient)->setIpAddresses(['192.168.10.101', '192.168.10.102']);

        // Assert
        $this->assertEquals(['192.168.10.101', '192.168.10.102'], $client->getIpAddresses());
    }
    
    public function test_new_client_set_secret_property_value()
    {
        // Act
        $client = (new NewClient)->setSecret($bytes = random_int(1000, 10000).time());

        // Assert
        $this->assertEquals($bytes, $client->getSecret());
    }
    
    public function test_new_client_app_url_property_value()
    {
        // Act
        $client = (new NewClient)->setAppUrl($host = 'http://localhost:3000');

        // Assert
        $this->assertEquals($host, $client->getAppUrl());
    }

    public function test_new_client_set_revoked_property_value()
    {
        // Act
        $client = (new NewClient)->setRevoked(true);

        // Assert
        $this->assertTrue($client->getRevoked());
    }

    public function test_new_client_set_expires_at_property_value()
    {
        // Act
        $client = (new NewClient)->setExpiresAt((new DateTimeImmutable)->modify('+1 days')->format('Y-m-d H:i:s'));

        // Assert
        $this->assertEquals((new DateTimeImmutable)->modify('+1 days')->format('Y-m-d H:i:s'), $client->getExpiresAt());
    }

    public function test_new_client_set_scopes_at_property_value()
    {
        // Act
        $client = (new NewClient)->setScopes(['app:posts:list']);

        // Assert
        $this->assertEquals(['app:posts:list'], $client->getScopes());
    }
}