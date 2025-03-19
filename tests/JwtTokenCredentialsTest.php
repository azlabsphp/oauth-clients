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

        $this->assertEmpty($credentials->getId());
        $this->assertEmpty($credentials->getSecret());

        $this->assertNotSame($credentials->getId(), $credentials2->getId());
        $this->assertNotSame($credentials->getSecret(), $credentials2->getSecret());
    }

    public function test_jwt_token_credentials_to_string_returns_a_jwt_token()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withPayload('apikey', 'apiSecret');

        $this->assertCount(3, explode('.', $jwtToken));
    }

    public function test_jwt_token_credentials_decode()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withPayload('apikey', 'apiSecret');

        $credentials2 = JwtTokenCredentials::new('SuperSecretPassword', $jwtToken);

        $this->assertSame('apikey', $credentials2->getId());

        $this->assertSame('apiSecret', $credentials2->getSecret());
    }

    public function test_jwt_token_credentials_throw_TokenExpires_exception()
    {
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withTTL(3)->withPayload('apikey', 'apiSecret');

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
        $this->expectException(\BadMethodCallException::class);

        // Act
        $jwtToken = (string) $credentials;
    }
}
