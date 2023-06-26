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

namespace Drewlabs\AuthorizedClients\Tests;

use Drewlabs\AuthorizedClients\Client;
use Drewlabs\AuthorizedClients\Contracts\ClientQueryInterface;
use Drewlabs\AuthorizedClients\Contracts\CredentialsIdentityInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class HttpQueryClientStub implements ClientQueryInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * creates class instance.
     *
     * @return void
     */
    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(CredentialsIdentityInterface $identity)
    {
        try {
            $request = $this->writeRequestBody($this->requestFactory->createRequest('POST', $this->url), $identity);
            $response = $this->client->sendRequest($this->setHeaders($request));
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode <= 204) {
                return new Client(json_decode($response->getBody()->__toString(), true));
            }

            return null;
        } catch (ClientExceptionInterface $e) {
            return null;
        }
    }

    /**
     * The endpoint from which the client is selected.
     *
     * @return static
     */
    public function setUrl(string $uri)
    {
        $this->url = $uri;

        return $this;
    }

    /**
     * Add header to the query client instance.
     *
     * @param mixed $value
     *
     * @return static
     */
    public function addHeader(string $name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return RequestInterface
     */
    private function writeRequestBody(RequestInterface $request, CredentialsIdentityInterface $identity)
    {
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->streamFactory->createStream($this->jsonEncode(['client' => (string) $identity->getId(), 'secret' => (string) $identity->getSecret()])));

        return $request;
    }

    /**
     * Set request headers on the request instance.
     *
     * @throws \InvalidArgumentException
     *
     * @return RequestInterface
     */
    private function setHeaders(RequestInterface $request)
    {
        // set headers to empty array if headers is null
        $headers = $this->headers ?? [];

        // for each header, we add the header to the request
        foreach ($headers as $name => $header) {
            // code...
            $request = $request->withHeader($name, $header);
        }

        // return the immutable request
        return $request;
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return string|false
     */
    private function jsonEncode($value, int $options = 0, int $depth = 512)
    {
        $json = json_encode($value, $options, $depth);
        if (\JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('json_encode error: '.json_last_error_msg());
        }
        /* @var string */
        return $json;
    }
}
