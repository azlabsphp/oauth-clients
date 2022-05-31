<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\AuthorizedClients;

use Closure;
use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\Contracts\ClientValidatorInterface;
use Drewlabs\AuthorizedClients\Contracts\Scope;
use Drewlabs\AuthorizedClients\Contracts\ScopedClient;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;

final class AuthorizedClientValidator implements ClientValidatorInterface
{
    /**
     * @var \Closure
     */
    private $selectorFunc;

    /**
     * @param \Closure|ClientSelector $selectorFunc This function will be used to select client from datasource
     *                                              using the clientId and clientSecret as parameters. This means that the selector function
     *                                              must accept the clientId and clientSecret as arguments
     *
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
        $client = ($this->selectorFunc)($clientId, $secret);
        // Check if client is NULL
        if (null === $client) {
            throw new UnAuthorizedClientException('client not found');
        }

        if ($client->isRevoked()) {
            throw new UnAuthorizedClientException('client has been revoked');
        }

        if ($client instanceof ScopedClient) {
            if (!$client->hasScope($scopes)) {
                if ($scopes instanceof Scope) {
                    $scopes = (string) $scopes;
                }
                $scopes = \is_string($scopes) ? [$scopes] : $scopes;
                throw UnAuthorizedClientException::forScopes(
                    $client->getKey(),
                    array_diff($client->getScopes(), $scopes)
                );
            }
        }

        // ! Provide the client request headers in the proxy request headers definition
        // Get Client IP Addresses
        $ips = $client->getIpAddressesAttribute();
        $ips = $ips ?: [];

        // Check whether * exists in the list of client ips
        if (!\in_array('*', $ips, true) && (null !== $requestIp)) {
            // // Return the closure handler for the next middleware
            // Get the request IP address
            if (!\in_array($requestIp, $ips, true)) {
                throw new UnAuthorizedClientException('invalid request source');
            }
        }

        return $client;
    }
}
