<?php

use Drewlabs\AuthorizedClients\Contracts\CredentialsIdentityInterface;
use Drewlabs\AuthorizedClients\Exceptions\AuthorizationException;
use Drewlabs\AuthorizedClients\JwtCookieCredentialsFactory;
use Drewlabs\AuthorizedClients\JwtTokenCredentials;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;

class JwtCookieCredentialsFactoryTest extends TestCase
{
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

    public function test_jwt_cookie_credentials_factory_creates_jwt_credentials()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string)($credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0'));
        $serverRequest = $this->createServerRequest();
        $serverRequest = $serverRequest->withCookieParams(['jwt-cookie' => $jwtToken]);

        // Act
        $credentials = (new JwtCookieCredentialsFactory('SuperSecretPassword'))->create($serverRequest);

        // Assert
        $this->assertInstanceOf(CredentialsIdentityInterface::class, $credentials);
        $this->assertEquals('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }

    public function test_jwt_cookie_credentials_factory_throws_authorization_exception()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        (string)($credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0'));
        $serverRequest = $this->createServerRequest();

        $this->expectException(AuthorizationException::class);
        // Act
        $credentials = (new JwtCookieCredentialsFactory('SuperSecretPassword'))->create($serverRequest);
        
    }
}