<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\CredentialsFactoryInterface;
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;

/**
 * @deprecated Use `CredentialsFactory` instead
 */
class CredentialsPipelineFactory implements CredentialsFactoryInterface
{
    /** @var CredentialsFactoryInterface */
    private $factory;

    /**
     * Create middleware class instance
     * 
     * @param CredentialsFactoryInterface[] ...$factories
     */
    public function __construct(...$factories)
    {
        $this->factory = new CredentialsFactory(...$factories);
    }

    public function create($request): ?CredentialsIdentityInterface
    {
        return $this->factory->create($request);
    }

}
