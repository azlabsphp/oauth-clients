<?php

namespace Drewlabs\AuthorizedClients\Middleware;

use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

trait CreatesPsr7Request
{
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request|null $request 
     * @return ServerRequestInterface 
     */
    public function psr7Request($request = null)
    {
        if ($request instanceof RequestInterface || $request instanceof ServerRequestInterface) {
            return $request;
        }
        $psr17Factory = new Psr17Factory();
        if ($request) {
            $psrHttpFactory = new PsrHttpFactory(
                $psr17Factory,
                $psr17Factory,
                $psr17Factory,
                $psr17Factory
            );
            return $psrHttpFactory->createRequest($request);
        }
        $psrHttpFactory = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );
        return $psrHttpFactory->fromGlobals();
    }

    /**
     * 
     * @param ServerRequestInterface $request 
     * @return string 
     */
    public function ip(ServerRequestInterface $request)
    {
        return empty($value = is_array($addresses = $this->getPsr7Ips($request)) ? $this->first($addresses) : $addresses) ?
            $this->getHeader($request, 'X-Real-IP') :
            $value;
    }

    /**
     * 
     * @param array $list 
     * @return mixed 
     */
    private function first(array $list)
    {
        return !empty($list) ? (\array_slice($list, 0, 1, false)[0] ?? null) : null;
    }

    /**
     * 
     * @return array 
     */
    private function getPsr7Ips(ServerRequestInterface $request)
    {
        $addresses = [];
        foreach ([
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ] as $key) {
            $attribute = is_array($value = $this->server($request, $key)) ? $this->first($value) : $value;
            if (null === $attribute) {
                continue;
            }
            foreach (array_map('trim', explode(',', $attribute)) as $addr) {
                if (filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    $addresses[] = $addr;
                }
            }
        }
        return array_unique($addresses);
    }

    /**
     * 
     * @param string $key 
     * @return array|string 
     */
    private function server(ServerRequestInterface $request, string $key)
    {
        $server = $request->getServerParams() ?? [];
        return $key ? $server[$key] ?? null : $server;
    }

    private function getHeader(MessageInterface $request, string $name, $default = null)
    {
        $headers = $request->getHeader($name);
        return array_pop($headers) ?? (is_callable($default) ? $default() : $default);
    }
}
