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

namespace Drewlabs\AuthorizedClients\Tests;

use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClientStub implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $query = [];
        parse_str((string) $request->getUri()->getQuery(), $query);
        $attributes = array_values(array_filter(ClientsStub::getClients(), static function ($current) use ($query) {
            return $current['id'] === $query['client'] && $current['secret'] === $query['secret'];
        }));
        if (!empty($attributes)) {
            return new Response(200, [], json_encode($attributes[0]));
        }
        return new Response(404);
    }
}
