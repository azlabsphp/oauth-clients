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

namespace Drewlabs\Oauth\Clients\Tests;

use Drewlabs\Oauth\Clients\Client;
use Drewlabs\Oauth\Clients\Contracts\ClientInterface;
use Drewlabs\Oauth\Clients\Contracts\ClientProviderInterface;
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Tests\Stubs\AttributeAwareStub;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class HttpQueryClientStub implements ClientProviderInterface
{
    /** @var PsrClientInterface */
    private $client;

    /** @var string */
    private $url;

    /** @var RequestFactoryInterface */
    private $requestFactory;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /** @var array */
    private $headers = [];

    /**
     * creates class instance.
     *
     * @return void
     */
    public function __construct(PsrClientInterface $client, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(CredentialsIdentityInterface $credentials): ?ClientInterface
    {
        return $this->findByCredentials($credentials);
    }

    public function findByApiKey(string $apiKey): ?ClientInterface
    {
        throw new \RuntimeException('Unimplemented method');
    }

    public function findByCredentials(CredentialsIdentityInterface $identity): ?ClientInterface
    {
        try {
            $request = $this->writeRequestBody($this->requestFactory->createRequest('POST', $this->url), [
                'client' => (string) $identity->getId(),
                'secret' => (string) $identity->getSecret(),
            ]);
            $response = $this->client->sendRequest($this->setHeaders($request));
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode <= 204) {
                return new Client(new AttributeAwareStub(json_decode($response->getBody()->__toString(), true)));
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
    private function writeRequestBody(RequestInterface $request, array $body)
    {
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->streamFactory->createStream($this->jsonEncode($body)));

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
