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

use Drewlabs\Oauth\Clients\BasicAuthCredentials;
use Drewlabs\Oauth\Clients\BasicAuthorizationCredentialsFactory;

use Drewlabs\Oauth\Clients\Tests\Stubs\PsrServerRequestFacade;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;

class BasicAuthorizationCredentialsFactoryTest extends TestCase
{
    public function test_basic_authorization_credentials_factory_create()
    {
        $request = $this->createServerRequest();
        $request = $request->withAddedHeader('Authorization', 'Basic '.base64_encode(sprintf('%s:%s', 'apiKey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0')));

        // Act
        $credentials = (new BasicAuthorizationCredentialsFactory(new PsrServerRequestFacade()))->create($request);

        // Assert
        $this->assertInstanceOf(BasicAuthCredentials::class, $credentials);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }

    public function test_basic_authorization_credentials_factory_create_returns_null_case_basic_credentials_not_provided()
    {
        $request = $this->createServerRequest();
        // Act
        $credentials = (new BasicAuthorizationCredentialsFactory(new PsrServerRequestFacade()))->create($request);
        $this->assertNull($credentials);
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
