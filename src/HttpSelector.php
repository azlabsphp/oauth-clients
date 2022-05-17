<?php

namespace Drewlabs\AuthorizedClients;

use Drewlabs\AuthorizedClients\Contracts\ClientSelector;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class HttpSelector implements ClientSelector
{
    /**
     * 
     * @var ClientInterface
     */
    private $client;

    /**
     * 
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
            $request = $psr17Factory->createRequest('GET', sprintf("%s?client=%s&secret=%s", $this->endpoint, (string)$clientId, (string)$secret));
            $response = $this->client->sendRequest($request);
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode <= 204) {
                return new Client(json_decode($response->getBody(), true));
            }
            return null;
        } catch (ClientExceptionInterface $e) {
            return null;
        }
    }
}
