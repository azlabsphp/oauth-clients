<?php

use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Exceptions\TokenExpiresException;
use Drewlabs\Oauth\Clients\JwtTokenCredentials;
use PHPUnit\Framework\TestCase;

class JwtTokenCredentialsTest extends TestCase
{

    public function test_jwt_token_credentials_constructor()
    {
        $jwtTokenCredentials = new JwtTokenCredentials('SuperSecretPassword');

        $this->assertInstanceOf(CredentialsIdentityInterface::class, $jwtTokenCredentials);
    }

    public function test_jwt_token_credentials_with_payload()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');

        $credentials2 = $credentials->withPayload('apikey', 'apiSecret');

        $this->assertTrue(empty($credentials->getId()));
        $this->assertTrue(empty($credentials->getSecret()));

        $this->assertNotEquals($credentials->getId(), $credentials2->getId());
        $this->assertNotEquals($credentials->getSecret(), $credentials2->getSecret());
    }

    public function test_jwt_token_credentials_to_string_returns_a_jwt_token()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string)($credentials->withPayload('apikey', 'apiSecret'));

        $this->assertEquals(3, count(explode('.', $jwtToken)));
    }

    public function test_jwt_token_credentials_decode()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string)($credentials->withPayload('apikey', 'apiSecret'));

        $credentials2 = JwtTokenCredentials::new('SuperSecretPassword', $jwtToken);

        $this->assertEquals('apikey', $credentials2->getId());

        $this->assertEquals('apiSecret', $credentials2->getSecret());

    }

    public function test_jwt_token_credentials_throw_TokenExpires_exception()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string)($credentials->withTTL(3)->withPayload('apikey', 'apiSecret'));

        // Assert
        $this->expectException(TokenExpiresException::class);
        // Act
        sleep(5);
        JwtTokenCredentials::new('SuperSecretPassword', $jwtToken);
    }

    public function test_jwt_token_credentials_thows_BadMethodCallException_wihtout_with_payload_call()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');

        // Assert
        $this->expectException(BadMethodCallException::class);
        
        // Act
        $jwtToken = (string)($credentials);

    }
}
