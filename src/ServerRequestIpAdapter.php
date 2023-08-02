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

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestIpAdapter
{
    /**
     * @var mixed
     */
    private $request;

    /**
     * Creates class instance.
     *
     * @return void
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * resolve the first matching psr server request ip.
     *
     * @return string
     */
    public function ip()
    {
        return empty($value = \is_array($addresses = $this->ips($this->request)) ? $this->first($addresses) : $addresses) ? $this->getHeader($this->request, 'X-Real-IP') : $value;
    }

    /**
     * returns a list of ip addresses.
     *
     * @return string[]
     */
    public function ips(ServerRequestInterface $request)
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
     * @return array|string
     */
    private function server(ServerRequestInterface $request, string $key)
    {
        $server = $request->getServerParams() ?? [];

        return $key ? $server[$key] ?? null : $server;
    }

    /**
     * get request header value.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    private function getHeader(MessageInterface $request, string $name, $default = null)
    {
        $requestHeaders = $request->getHeader($name);

        return ($header = array_pop($requestHeaders)) ? $header : (\is_callable($default) ? $default() : $default);
    }
}
