<?php

namespace Drewlabs\AuthorizedClients\Proxy;

use Closure;
use Drewlabs\AuthorizedClients\HttpSelector;
use Psr\Http\Client\ClientInterface;
use Drewlabs\AuthorizedClients\Contracts\ClientSelector;

/**
 * 
 * @param ClientInterface $client 
 * @param string $endpoint 
 * @return Closure
 */
function useHTTPSelector(ClientInterface $client, string $endpoint)
{
    /**
     * @return ClientSelector
     */
    return function (string $user, string $secret) use ($client, $endpoint) {
        return HttpSelector::using($client)
            ->from($endpoint)
            ->withCredentials($user, $secret);
    };
}
