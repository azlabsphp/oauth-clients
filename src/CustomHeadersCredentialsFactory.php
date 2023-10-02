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

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\CredentialsFactoryInterface;
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Contracts\ServerRequestFacade;

class CustomHeadersCredentialsFactory implements CredentialsFactoryInterface
{
    /**
     * @var ServerRequestFacade
     */
    private $serverRequest;

    /**
     * Create class instance
     * 
     * @param ServerRequestFacade $serverRequest 
     */
    public function __construct(ServerRequestFacade $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }


    public function create($request)
    {
        // query identity from request cookie
        $credentials = $this->fromCookie($request);

        // query identity from request headers
        if (null === $credentials) {
            $credentials = $this->fromHeaders($request);
        }

        // Return the constructed credentials
        return $credentials;
    }

    /**
     * returns a credentials instance from request cookie.
     *
     * @return CredentialsIdentityInterface|null
     */
    private function fromCookie($request)
    {
        // get request cookies
        $clientId = $this->serverRequest->getRequestCookie($request, 'clientid');

        // query for clientid cookie value
        if (empty($clientId)) {
            return null;
        }
        $clientsecret = $this->serverRequest->getRequestCookie($request, 'clientsecret');

        // query for clientsecret cookie value
        if (empty($clientsecret)) {
            return null;
        }

        return new Credentials($clientId, $clientsecret);
    }

    /**
     * Read a (client, secret) from request headers or request parsed body.
     *
     * @return Credentials|null
     */
    private function fromHeaders($request)
    {
        // query for client secret header value
        if (null === ($secret = $this->getAuthSecret($request))) {
            return null;
        }

        // query fir client id header value
        if (null === ($client = $this->getClientId($request))) {
            return null;
        }

        return new Credentials($client, $secret);
    }

    private function getAuthSecret($request)
    {
        // We search for authorization secret using all possible header values
        // in order to support legacy applications
        $secret = $this->serverRequest->getRequestHeader($request, 'x-client-secret');
        $secret = $secret ?? $this->serverRequest->getRequestHeader($request, 'x-authorization-client-secret');
        $secret = $secret ?? $this->serverRequest->getRequestHeader($request, 'x-authorization-client-token');
        if (null === $secret && !empty($value = $this->serverRequest->getRequestAttribute($request, 'client_secret'))) {
            return $value;
        }
        return $secret;
    }

    private function getClientId($request)
    {
        $clientId = $this->serverRequest->getRequestHeader($request, 'x-authorization-client-id');
        $clientId = empty($clientId) ? $this->serverRequest->getRequestHeader($request, 'x-client-id') : $clientId;
        if (null === $clientId && !empty($value = $this->serverRequest->getRequestAttribute($request, 'client_id'))) {
            return $value;
        }
        return $clientId;
    }
}
