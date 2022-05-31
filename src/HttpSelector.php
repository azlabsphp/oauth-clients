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
use InvalidArgumentException;
use LogicException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;

final class HttpSelector implements ClientSelector
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $endpoint = 'http://localhost';

    /**
     *
     * @var StreamFactoryInterface|RequestFactoryInterface
     */
    private $factory;

    /**
     * 
     * @var string
     */
    private $user;

    /**
     * 
     * @var string
     */
    private $passphrase;

    /**
     * 
     * @var array
     */
    private $requestBody;

    /**
     * 
     * @param ClientInterface $client 
     * @return self 
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->factory = new \Nyholm\Psr7\Factory\Psr17Factory();
    }

    /**
     * 
     * @param ClientInterface $client 
     * @return self 
     */
    public static function using(ClientInterface $client)
    {
        return new self($client);
    }

    /**
     * Prepare the query parameters to be send to server
     * 
     * @param mixed $client 
     * @param mixed $secret 
     * @return self 
     */
    public function select($client, $secret)
    {
        $this->requestBody = ['client' => (string)$client, 'secret' => (string)$secret];
        return $this;
    }

    /**
     * The endpoint from which the client is selected
     * 
     * @param string $uri 
     * @return self 
     */
    public function from(string $uri)
    {
        $this->endpoint = $uri;
        return $this;
    }

    /**
     * Set the authorization options
     * 
     * @param string $user 
     * @param string $passphrase 
     * @return self 
     */
    public function withCredentials(string $user, string $passphrase)
    {
        $this->user = $user;
        $this->passphrase = $passphrase;
        return $this;
    }

    /**
     * Invoke the query on the server
     * 
     * @return Client|null 
     * @throws LogicException 
     * @throws InvalidArgumentException 
     */
    public function call()
    {
        $this->validateAuthorizationOptions();
        try {
            $request = $this->writeRequestBody($this->factory->createRequest('POST', $this->endpoint));
            $response = $this->client->sendRequest($this->setAuthHeaders($request));
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode <= 204) {
                return new Client(json_decode($response->getBody()->__toString(), true));
            }
            return null;
        } catch (ClientExceptionInterface $e) {
            return null;
        }
    }

    public function __invoke($client, $secret)
    {
        return $this->select($client, $secret)->call();
    }

    /**
     * 
     * @param RequestInterface $request 
     * @param string $client 
     * @param string $secret 
     * @return RequestInterface 
     * @throws InvalidArgumentException 
     */
    private function writeRequestBody(RequestInterface $request)
    {
        if (empty($this->requestBody)) {
            throw new LogicException('No query parameter found, prepare the query by calling select($client, $secret) method before invoking the query');
        }
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->factory->createStream($this->jsonEncode($this->requestBody)));
        return $request;
    }

    /**
     * 
     * @param RequestInterface $request 
     * @return RequestInterface 
     * @throws InvalidArgumentException 
     */
    private function setAuthHeaders(RequestInterface $request)
    {
        $request = $request->withHeader('x-client-id', $this->user);
        $request = $request->withHeader('x-client-secret', $this->passphrase);
        return $request;
    }

    /**
     * 
     * @return void 
     * @throws LogicException 
     */
    private function validateAuthorizationOptions()
    {
        if (!is_string($this->user) || !is_string($this->passphrase)) {
            throw new LogicException('Selector object requires authorization options to be initialize before being invoked');
        }
    }

    /**
     * 
     * @param mixed $value 
     * @param int $options 
     * @param int $depth 
     * @return string|false 
     * @throws InvalidArgumentException 
     */
    private function jsonEncode($value, int $options = 0, int $depth = 512)
    {
        $json = \json_encode($value, $options, $depth);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new InvalidArgumentException('json_encode error: ' . \json_last_error_msg());
        }

        /** @var string */
        return $json;
    }
}
