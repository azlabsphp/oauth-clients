<?php

namespace Drewlabs\AuthorizedClients\Middleware;

use Closure;
use Drewlabs\AuthorizedClients\Contracts\ClientValidatorInterface;
use Drewlabs\AuthorizedClients\Contracts\RequestClientCredentialsReader;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\RequestClientReader;
use InvalidArgumentException;

class FirstPartyAuthorizedClients
{
    use CreatesPsr7Request;

    /**
     *
     * @var ClientValidatorInterface
     */
    private $clientsValidator;

    /**
     *
     * @var RequestClientCredentialsReader
     */
    private $requestClientReader;

    /**
     * 
     * @param ClientValidatorInterface $clientsValidator 
     * @param RequestClientCredentialsReader|null $requestClientReader 
     */
    public function __construct(ClientValidatorInterface $clientsValidator, RequestClientCredentialsReader $requestClientReader = null)
    {
        $this->clientsValidator = $clientsValidator;
        $this->requestClientReader = $requestClientReader ?? new RequestClientReader();
    }

    /**
     * Handle an incoming request.
     * 
     * @param mixed $request 
     * @param Closure $next 
     * @return mixed 
     * @throws InvalidArgumentException 
     * @throws UnAuthorizedClientException 
     */
    public function handle($request, Closure $next)
    {
        return $this->__invoke($request, null, $next);
    }

    /**
     * Handles incoming request
     * 
     * @param mixed $request 
     * @param mixed $response 
     * @param callable $next 
     * @return mixed 
     * @throws InvalidArgumentException 
     * @throws UnAuthorizedClientException 
     */
    public function __invoke($request, $response, $next)
    {
        [$client, $secret] = $this->requestClientReader->read($this->psr7Request($request));
        $client = $this->clientsValidator->validate($client, $secret);
        if (!$client->firstParty()) {
            throw new UnAuthorizedClientException('client is not a first party client');
        }
        return null !== $response ? $next($request, $response) : $next($request);
    }
}
