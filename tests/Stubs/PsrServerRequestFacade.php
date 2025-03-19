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

namespace Drewlabs\Oauth\Clients\Tests\Stubs;

use Drewlabs\Oauth\Clients\Contracts\ServerRequestFacade;
use Psr\Http\Message\ServerRequestInterface;

class PsrServerRequestFacade implements ServerRequestFacade
{
    /**
     * {@inheritDoc}
     *
     * @param ServerRequestInterface $request
     */
    public function getRequestCookie($request, ?string $name = null)
    {
        $cookies = $request->getCookieParams();

        return $cookies[$name] ?? null;
    }

    /**
     * {@inheritDoc}
     *
     * @param ServerRequestInterface $request
     */
    public function getRequestIp($request)
    {
        return empty($value = \is_array($addresses = $this->getRequestIps($request)) ? $this->first($addresses) : $addresses) ? $this->getRequestHeader($request, 'X-Real-IP') : $value;
    }

    /**
     * {@inheritDoc}
     *
     * @param ServerRequestInterface $request
     */
    public function getRequestHeader($request, string $name, $default = null)
    {
        $header = $request->getHeader($name);
        if (null === $header) {
            return null;
        }
        if (null === ($header = array_pop($header))) {
            return null;
        }

        return $header;
    }

    /**
     * {@inheritDoc}
     *
     * @param ServerRequestInterface $request
     */
    public function getRequestAttribute($request, string $name)
    {
        // Search in request attributes
        $result = $request->getAttribute($name);
        if (null !== $result) {
            return $result;
        }

        // Search in the request query parameter
        $query = (array) ($request->getQueryParams() ?? []);
        if (isset($query[$name])) {
            return $query[$name];
        }
        // Search in the request parsed body
        $body = (array) ($request->getParsedBody() ?? []);
        if (isset($body[$name])) {
            return $body[$name];
        }
    }

    public function getAuthorizationHeader($request, ?string $method = null)
    {
        $header = $this->getRequestHeader($request, 'authorization');
        if (null === $header) {
            return null;
        }
        $header = \is_array($header) ? array_pop($header) : $header;
        if (null === $header) {
            return null;
        }
        if (!$this->startsWith(strtolower($header), $method)) {
            return null;
        }

        return trim(str_ireplace($method, '', $header));
    }

    /**
     * returns a list of ip addresses.
     *
     * @param ServerRequestInterface $request
     *
     * @return string[]
     */
    public function getRequestIps($request)
    {
        $addresses = [];
        foreach ([
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ] as $key) {
            if (null === ($attribute = \is_array($value = $this->server($request, $key)) ? $this->first($value) : $value)) {
                continue;
            }
            foreach (array_map('trim', explode(',', $attribute)) as $addr) {
                if (false !== filter_var($addr, \FILTER_VALIDATE_IP, \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE)) {
                    $addresses[] = $addr;
                }
            }
        }

        return array_unique($addresses);
    }

    /**
     * checks if `$haystack` string starts with `$needle`.
     *
     * @return bool
     */
    private function startsWith(string $haystack, string $needle)
    {
        if (version_compare(\PHP_VERSION, '8.0.0') >= 0) {
            return str_starts_with($haystack, $needle);
        }

        return ('' === $needle) || (mb_substr($haystack, 0, mb_strlen($needle)) === $needle);
    }

    /**
     * returns the first element in a list.
     *
     * @return mixed
     */
    private function first(array $list)
    {
        return !empty($list) ? (\array_slice($list, 0, 1, false)[0] ?? null) : null;
    }

    /**
     * get server param value.
     *
     * @param ServerRequestInterface $request
     *
     * @return array|string
     */
    private function server($request, string $key)
    {
        $server = $request->getServerParams() ?? [];

        return $key ? $server[$key] ?? null : $server;
    }
}
