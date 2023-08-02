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
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;

class CustomHeadersCredentialsFactory implements CredentialsFactoryInterface
{
    use InteractWithServerRequest;

    public function create(ServerRequestInterface $request)
    {
        // query identity from request cookie
        $credentials = $this->fromCookie($request);

        // query identity from request headers
        if (null === $credentials) {
            $credentials = $this->fromHeaders($request);
        }

        // throw an exception if the credentials is not found
        if (null === $credentials) {
            throw new AuthorizationException('authorization headers and cookies not found');
        }

        return $credentials;
    }

    /**
     * returns a credentials instance from request cookie.
     *
     * @return CredentialsIdentityInterface|null
     */
    private function fromCookie(ServerRequestInterface $request)
    {
        // get request cookies
        $cookies = $request->getCookieParams();

        // query for clientid cookie value
        if (!isset($cookies['clientid'])) {
            return null;
        }

        // query for clientsecret cookie value
        if (!isset($cookies['clientsecret'])) {
            return null;
        }

        return new Credentials($cookies['clientid'], $cookies['clientsecret']);
    }

    /**
     * Read a (client, secret) from request headers or request parsed body.
     *
     * @throws AuthorizationException
     *
     * @return array
     */
    private function fromHeaders(ServerRequestInterface $request)
    {
        // query for client secret header value
        if (null === ($secret = $this->getAuthSecret($request))) {
            throw new AuthorizationException('client secret header value not found');
        }

        // query fir client id header value
        if (null === ($client = $this->getClientID($request))) {
            throw new AuthorizationException('client id header value not found');
        }

        return new Credentials($client, $secret);
    }

    private function getAuthSecret($request)
    {
        // We search for authorization secret using all possible header values
        // in order to support legacy applications
        $secret = $this->getHeader($request, 'x-client-secret', '');
        $secret = $secret ?? $this->getHeader($request, 'x-authorization-client-secret', '');
        $secret = $secret ?? $this->getHeader($request, 'x-authorization-client-token', '');
        $query = (array) ($request->getQueryParams() ?? []);
        if (null === $secret && isset($query['client_secret'])) {
            return $query['client_secret'];
        }
        $body = (array) ($request->getParsedBody() ?? []);
        if (null === $secret && isset($body['client_secret'])) {
            return $body['client_secret'];
        }

        return $secret;
    }

    private function getClientID($request)
    {
        $header = $request->getHeader('x-authorization-client-id');
        $header = empty($header) ? $request->getHeader('x-client-id') : $header;
        $clientId = array_pop($header);
        $query = (array) ($request->getQueryParams() ?? []);
        if (null === $clientId && isset($query['client_id'])) {
            return $query['client_id'];
        }
        $body = (array) ($request->getParsedBody() ?? []);
        if (null === $clientId && isset($body['client_id'])) {
            return $body['client_id'];
        }

        return $clientId;
    }
}
