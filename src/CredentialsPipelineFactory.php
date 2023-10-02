<?php

namespace Drewlabs\Oauth\Clients;

use Closure;
use Drewlabs\Oauth\Clients\Contracts\CredentialsFactoryInterface;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;

class CredentialsPipelineFactory implements CredentialsFactoryInterface
{
    /**
     * @var CredentialsFactoryInterface[]
     */
    private $factories = [];

    /**
     * Create middleware class instance
     * 
     * @param CredentialsFactoryInterface $customHeadersFactory 
     * @param CredentialsFactoryInterface $basicAuthCredentialsFactory 
     * @param CredentialsFactoryInterface $jwtHeaderFactory 
     * @param CredentialsFactoryInterface $jwtCookieFactory 
     */
    public function __construct(
        CredentialsFactoryInterface $customHeadersFactory = null,
        CredentialsFactoryInterface $basicAuthCredentialsFactory = null,
        CredentialsFactoryInterface $jwtHeaderFactory = null,
        CredentialsFactoryInterface $jwtCookieFactory = null
    ) {
        $this->factories = [
            $customHeadersFactory,
            $basicAuthCredentialsFactory,
            $jwtHeaderFactory,
            $jwtCookieFactory,
        ];
    }

    /**
     * Create a callable that resolve client credentials from request instance
     * 
     * @param mixed $request
     * 
     * @return CredentialsIdentityInterface
     */
    public function create($request)
    {
        $factories = array_filter($this->factories ?? [], function ($factory) {
            return null !== $factory;
        });
        $callbacks = array_map(function (CredentialsFactoryInterface $factory) use ($request) {
            return function ($credentials = null) use (&$factory, $request) {
                if (null === $credentials) {
                    return $factory->create($request);
                }
                return $credentials;
            };
        }, $factories);

        $credentials = $this->compose($callbacks)(null);
    
        if (null === $credentials) {
            throw new AuthorizationException('authorization key was not found');
        }

        return $credentials;
    }

    /**
     * Creates a pipeline of function through which the request is processed
     * to create a client credentials instance
     * 
     * @param callable[] $callbacks 
     * @return Closure(mixed $source): mixed 
     */
    private function compose(array $callbacks)
    {
        return static function ($source) use ($callbacks) {
            return array_reduce(
                $callbacks,
                static function ($carry, $func) {
                    return $func($carry);
                },
                $source
            );
        };
    }
}
