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

use Drewlabs\AuthorizedClients\Contracts\ClientSelector;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class HttpSelector implements ClientSelector
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $endpoint;

    public function __construct(ClientInterface $client, string $endpoint = 'http://localhost:8000/api/clients')
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    public function __invoke($clientId, $secret)
    {
        try {
            $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
            $request = $psr17Factory->createRequest('GET', sprintf('%s?client=%s&secret=%s', $this->endpoint, (string) $clientId, (string) $secret));
            $response = $this->client->sendRequest($request);
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode <= 204) {
                return new Client(json_decode($response->getBody()->__toString(), true));
            }

            return null;
        } catch (ClientExceptionInterface $e) {
            return null;
        }
    }
}
