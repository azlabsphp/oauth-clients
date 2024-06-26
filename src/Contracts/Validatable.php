<?php

namespace Drewlabs\Oauth\Clients\Contracts;

use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Drewlabs\Oauth\Clients\Exceptions\MissingScopesException;

/**
 * @internal
 * 
 * @deprecated
 * 
 * **Note** This interface is internal as it should not be implemented by outside classes
 *          as `validate(...)` method will be merged into `ClientInterface` contract.
 *          It's temporary extracted from `ClientInterface` to prevent any breaking change
 *          in existing implementation libraries
 *          
 */
interface Validatable
{

    /**
     * returns a boolean flag which equals true if client is matches the specified
     * scopes and allows request from the given ip address
     * 
     * @param array $scopes 
     * @param string|null $ip
     * 
     * @throws AuthorizationException
     * 
     * @return bool 
     */
    public function validate(array $scopes = [], string $ip = null): bool;
}