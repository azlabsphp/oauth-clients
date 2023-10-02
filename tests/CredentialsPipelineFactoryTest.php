<?php

use Drewlabs\Oauth\Clients\BasicAuthCredentials;
use Drewlabs\Oauth\Clients\BasicAuthorizationCredentialsFactory;
use Drewlabs\Oauth\Clients\CredentialsPipelineFactory;
use Drewlabs\Oauth\Clients\JwtAuthorizationHeaderCredentialsFactory;
use Drewlabs\Oauth\Clients\JwtCookieCredentialsFactory;
use Drewlabs\Oauth\Clients\JwtTokenCredentials;
use Drewlabs\Oauth\Clients\Tests\Stubs\PsrServerRequestFacade;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\Factory\Psr17Factory;
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;

class CredentialsPipelineFactoryTest extends TestCase
{

    private function createPipeline(array $factories)
    {
        return new CredentialsPipelineFactory(...$factories);
    }

    public function test_credentials_pipeline_create_client_credentials_if_jwt_cookis_is_provided()
    {
        $factory = $this->createPipeline([new JwtCookieCredentialsFactory(new PsrServerRequestFacade, 'SuperSecretPassword')]);
        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0');
        $serverRequest = $this->createServerRequest();
        $serverRequest = $serverRequest->withCookieParams(['jwt-cookie' => $jwtToken]);

        // Act
        $credentials = $factory->create($serverRequest);

        // Assert
        $this->assertInstanceOf(CredentialsIdentityInterface::class, $credentials);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }


    public function test_credentials_pipeline_create_client_credentials_if_basic_authorization()
    {
        $factory = $this->createPipeline([new BasicAuthorizationCredentialsFactory(new PsrServerRequestFacade)]);
        $request = $this->createServerRequest();
        $request = $request->withAddedHeader('Authorization', 'Basic ' . base64_encode(sprintf('%s:%s', 'apiKey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0')));

        // Act
        $credentials = $factory->create($request);

        // Assert
        $this->assertInstanceOf(BasicAuthCredentials::class, $credentials);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }


    public function test_credentials_pipeline_create_client_credentials_if_jwt_authorization_header()
    {
        $factory = $this->createPipeline([new JwtAuthorizationHeaderCredentialsFactory(new PsrServerRequestFacade, 'SuperSecretPassword')]);

        $credentials = new JwtTokenCredentials('SuperSecretPassword');
        $jwtToken = (string) $credentials->withTTL(3)->withPayload('apikey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0');
        $serverRequest = $this->createServerRequest();
        $serverRequest = $serverRequest->withAddedHeader('Authorization', sprintf('jwt %s', $jwtToken));

        // Act
        $credentials = $factory->create($serverRequest);

        // Assert
        $this->assertInstanceOf(CredentialsIdentityInterface::class, $credentials);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $credentials->getSecret());
    }

    public function test_credentials_pipeline_create_throws_an_exception_case_factories_return_null()
    {
        // Assert
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('authorization key was not found');

        // Initialize
        $factory = $this->createPipeline([
            new JwtAuthorizationHeaderCredentialsFactory(new PsrServerRequestFacade, 'SuperSecretPassword'),
            new BasicAuthorizationCredentialsFactory(new PsrServerRequestFacade),
            new JwtCookieCredentialsFactory(new PsrServerRequestFacade, 'SuperSecretPassword')
        ]);


        // Act
        $factory->create($this->createServerRequest());
    }

    public function test_credentials_pipeline_create_throws_an_exception_case_no_factory_provided()
    {
        // Assert
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('authorization key was not found');

        // Initialize
        $factory = $this->createPipeline([]);

        // Act
        $factory->create($this->createServerRequest());
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
