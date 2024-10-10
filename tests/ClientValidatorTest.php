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
use Drewlabs\Oauth\Clients\CredentialsValidator;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Drewlabs\Oauth\Clients\Tests\HttpClientStub;
use Drewlabs\Oauth\Clients\Tests\HttpQueryClientStub;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class ClientValidatorTest extends TestCase
{
    public function createSelector()
    {
        return (new HttpQueryClientStub(new HttpClientStub(), new Psr17Factory(), new Psr17Factory()))
            ->setUrl('http://localhost')
            ->addHeader('x-client-secret', '<CLIENT_ID>')
            ->addHeader('x-client-id', '<CLIENT_SECRET>');
    }

    public function test_validate_returns_instance_of_client_interface()
    {
        $validator = new CredentialsValidator($this->createSelector());
        $client = $validator->validate(new Credentials('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf'));
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }

    public function test_validate_throws_exception_for_missing_client_id_or_secret()
    {
        $this->expectException(AuthorizationException::class);
        $validator = new CredentialsValidator($this->createSelector());
        $validator->validate(new Credentials('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1f'));
    }

    public function test_validate_throws_exception_for_missing_scopes()
    {
        $this->expectException(AuthorizationException::class);
        $validator = new CredentialsValidator($this->createSelector());
        $validator->validate(new Credentials('e28df7be-e9f7-4bd4-a689-c8a8d51afe96', '35a56ee81ae61f7464d4bffae812eafea2534c63'), ['sys:all']);
    }

    public function test_callable_selector()
    {
        $validator = new CredentialsValidator(function ($identity) {
            $internal = $this->createSelector();

            return $internal->__invoke($identity);
        });
        $client = $validator->validate(new Credentials('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf'));
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }
}
