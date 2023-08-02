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

use Drewlabs\Oauth\Clients\NewClient;
use PHPUnit\Framework\TestCase;

class NewClientTest extends TestCase
{
    public function test_new_client_set_name_set_name_property_value()
    {
        // Act
        $client = (new NewClient())->setName('Test Client');

        // Assert
        $this->assertSame('Test Client', $client->getName());
    }

    public function test_new_client_set_user_id_property_value()
    {
        // Initialize
        $client = (new NewClient())->setName(null);

        // Assert
        $this->assertNull($client->getUserId());

        // Act
        $client = $client->setUserId((string) 1297);

        // Assert
        $this->assertSame('1297', $client->getUserId());
    }

    public function test_new_client_set_redirect_url_property_value()
    {
        // Act
        $client = (new NewClient())->setRedirectUrl('https://api.micronaut.app');

        // Assert
        $this->assertSame('https://api.micronaut.app', $client->getRedirectUrl());
    }

    public function test_new_client_set_provider_property_value()
    {
        // Act
        $client = (new NewClient())->setProvider('drewlabs:jwt');

        // Assert
        $this->assertSame('drewlabs:jwt', $client->getProvider());
    }

    public function test_new_client_set_ip_addresses_property_value()
    {
        // Act
        $client = (new NewClient())->setIpAddresses(['192.168.10.101', '192.168.10.102']);

        // Assert
        $this->assertSame(['192.168.10.101', '192.168.10.102'], $client->getIpAddresses());
    }

    public function test_new_client_set_secret_property_value()
    {
        // Act
        $client = (new NewClient())->setSecret($bytes = random_int(1000, 10000).time());

        // Assert
        $this->assertSame($bytes, $client->getSecret());
    }

    public function test_new_client_app_url_property_value()
    {
        // Act
        $client = (new NewClient())->setAppUrl($host = 'http://localhost:3000');

        // Assert
        $this->assertSame($host, $client->getAppUrl());
    }

    public function test_new_client_set_revoked_property_value()
    {
        // Act
        $client = (new NewClient())->setRevoked(true);

        // Assert
        $this->assertTrue($client->getRevoked());
    }

    public function test_new_client_set_expires_at_property_value()
    {
        // Act
        $client = (new NewClient())->setExpiresAt((new DateTimeImmutable())->modify('+1 days')->format('Y-m-d H:i:s'));

        // Assert
        $this->assertSame((new DateTimeImmutable())->modify('+1 days')->format('Y-m-d H:i:s'), $client->getExpiresAt());
    }

    public function test_new_client_set_scopes_at_property_value()
    {
        // Act
        $client = (new NewClient())->setScopes(['app:posts:list']);

        // Assert
        $this->assertSame(['app:posts:list'], $client->getScopes());
    }

    public function test_new_client_with_second_parameter_true_creates_a_personal_access_client()
    {
        // Act
        $client = (new NewClient(null, true));

        // Assert
        $this->assertTrue($client->isPersonalClient());

        // Act
        $client2 = (new NewClient(null, false));

        $this->assertFalse($client2->isPersonalClient());
    }

    public function test_new_client_with_no_argument_create_a_client_that_is_not_personal_client()
    {
        // Act
        $client = new NewClient;

        // Assert
        $this->assertFalse($client->isPersonalClient());
    }

    public function test_new_client_with_third_parameter_true_creates_a_personal_access_client()
    {
        // Act
        $client = (new NewClient(null, false, true));

        // Assert
        $this->assertTrue($client->isPasswordClient());

        // Act
        $client2 = (new NewClient(null, false, false));

        $this->assertFalse($client2->isPasswordClient());
    }

    public function test_new_client_with_no_argument_create_a_client_that_is_not_password_client()
    {
        // Act
        $client = new NewClient;

        // Assert
        $this->assertFalse($client->isPasswordClient());
    }
}
