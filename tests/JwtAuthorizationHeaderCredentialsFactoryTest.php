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

use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Drewlabs\Oauth\Clients\JwtAuthorizationHeaderCredentialsFactory;
use Drewlabs\Oauth\Clients\JwtTokenCredentials;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;

class JwtAuthorizationHeaderCredentialsFactoryTest extends TestCase
{
    public function test_jwt_authorization_header_credentials_factory_creates_jwt_credentials()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0');
        $serverRequest = $this->createServerRequest();
        $serverRequest = $serverRequest->withAddedHeader('Authorization', sprintf('jwt %s', $jwtToken));

        // Act
        $credentials = (new JwtAuthorizationHeaderCredentialsFactory('SuperSecretPassword'))->create($serverRequest);

        // Assert
        $this->assertInstanceOf(CredentialsIdentityInterface::class, $credentials);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }

    public function test_jwt_authorization_header_credentials_factory_throws_authorization_exception()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        (string) $credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0');
        $serverRequest = $this->createServerRequest();

        $this->expectException(AuthorizationException::class);
        // Act
        $credentials = (new JwtAuthorizationHeaderCredentialsFactory('SuperSecretPassword'))->create($serverRequest);

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
