<?php

namespace Drewlabs\AuthorizedClients;

use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Psr\Http\Message\ServerRequestInterface;

class RequestClientReader
{

    /**
     * Returns a (client, secret) tuple from provided request
     * 
     * @param ServerRequestInterface $request
     * @return array 
     * @throws UnAuthorizedClientException 
     */
    public function read(ServerRequestInterface $request)
    {
        [$client, $secret] = $this->fromCookie($request);
        if (null === $client || null === $secret) {
            [$client, $secret] = $this->fromHeaders($request);
        }
        return [$client, $secret];
    }


    /**
     * Returns a (client, secret) tuple from request cookie
     * 
     * @param ServerRequestInterface $request
     * 
     * @return array 
     */
    private function fromCookie(ServerRequestInterface $request)
    {
        $cookies = $request->getCookieParams();
        $clientId = $cookies['clientid'] ?? null;
        $clientSecret = $cookies['clientsecret'] ?? null;
        return [$clientId, $clientSecret];
    }

    /**
     * Read a (client, secret) from request headers or request parsed body
     * 
     * @param ServerRequestInterface $request
     * @return array 
     * @throws UnAuthorizedClientException 
     */
    private function fromHeaders(ServerRequestInterface $request)
    {
        $secret = $this->getAuthSecret($request);
        if (null === $secret) {
            throw new UnAuthorizedClientException("Missing client secret");
        }
        $clientId = $this->getClientID($request);
        return [$clientId, $secret];
    }

    private function getAuthSecret($request)
    {
        // We search for authorization secret using all possible header values
        // in order to support legacy applications
        $secret = $this->getFromHeader($request, 'x-client-secret', '');
        $secret = $secret ?? $this->getFromHeader($request, 'x-authorization-client-secret', '');
        $secret = $secret ?? $this->getFromHeader($request, 'x-authorization-client-token', '');
        $query = (array)($request->getQueryParams() ?? []);
        if (null === $secret && isset($query['client_secret'])) {
            return $query['client_secret'];
        }
        $body = (array)($request->getParsedBody() ?? []);
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
        $query = (array)($request->getQueryParams() ?? []);
        if (null === $clientId && isset($query['client_id'])) {
            return $query['client_id'];
        }
        $body = (array)($request->getParsedBody() ?? []);
        if (null === $clientId && isset($body['client_id'])) {
            return $body['client_id'];
        }
        return $clientId;
    }

    /**
     * Parse token from the authorization header.
     *
     * @param ServerRequestInterface $request
     * @param string                 $header
     * @param string                 $method
     *
     * @return ?string
     */
    private function getFromHeader($request, $header = 'authorization', $method = 'bearer')
    {
        $header = $request->getHeader($header);
        if (null === $header) {
            return null;
        }
        $header = array_pop($header);
        if (null === $header) {
            return null;
        }
        if (!$this->startsWith(strtolower($header), $method)) {
            return null;
        }
        return trim(str_ireplace($method, '', $header));
    }

    private function startsWith(string $haystack, string $needle)
    {
        if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
            return str_starts_with($haystack, $needle);
        }
        return ('' === $needle) || (mb_substr($haystack, 0, mb_strlen($needle)) === $needle);
    }
}