<?php

namespace Drewlabs\AuthorizedClients;

use Closure;
use Drewlabs\AuthorizedClients\Contracts\ClientValidatorInterface;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\Contracts\ClientInterface;

final class AuthorizedClientValidator implements ClientValidatorInterface
{

    /**
     * 
     * @var Closure
     */
    private $selectorFunc;

    /**
     * 
     * @param Closure|ClientSelector $selectorFunc This function will be used to select client from datasource
     *                                   using the clientId and clientSecret as parameters. This means that the selector function
     *                                   must accept the clientId and clientSecret as arguments
     * @return self 
     */
    public function __construct($selectorFunc)
    {
        $this->selectorFunc = $selectorFunc;
    }

    public function validate($clientId, $secret, $scopes = [], $requestIp = null)
    {

        // Find the client based on the provided token and id
        /**
         * @var ClientInterface
         */
        $client =  ($this->selectorFunc)($clientId, $secret);
        // Check if client is NULL
        if (null === $client) {
            throw new UnAuthorizedClientException();
        }
    
        if ($client->isRevoked()) {
            throw new UnAuthorizedClientException("Client has been revoked");
        }

        // If the first_party is passed an the request client is not first party return an unauthorized HTTP response
        $clientScopes = $client->getScopes() ?? ['*'];
        if (!in_array('*', $clientScopes) && !empty($scopes) && empty(array_intersect($scopes, $clientScopes ?? []))) {
            throw UnAuthorizedClientException::forScopes($client->getKey(), array_diff($clientScopes, $scopes));
        }

        //! Provide the client request headers in the proxy request headers definition
        // Get Client IP Addresses
        $ips = $client->getIpAddressesAttribute();
        $ips = $ips ?: [];

        // Check whether * exists in the list of client ips
        if (!in_array('*', $ips) && (null !== $requestIp)) {
            // // Return the closure handler for the next middleware
            // Get the request IP address
            if (!in_array($requestIp, $ips)) {
                throw new UnAuthorizedClientException("Invalid request source");
            }
        }
        return $client;
    }
}
