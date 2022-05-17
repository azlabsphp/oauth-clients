<?php

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * 
 * @package Drewlabs\AuthorizedClients\Contracts
 * 
 * @method ClientInterface validate($clientId, $secret, $scopes = [], $requestIp = null)
 */
interface ClientValidatorInterface
{
    /**
     * 
     * @param string|int $clientId 
     * @param string $secret 
     * @param array $scopes 
     * @param string $requestIp
     * @return ClientInterface 
     */
    public function validate($clientId, $secret, $scopes = [], $requestIp = null);
}