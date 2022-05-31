<?php

namespace Drewlabs\AuthorizedClients\Middleware;

use Closure;
use Drewlabs\AuthorizedClients\Contracts\ClientValidatorInterface;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\RequestClientReader;
use InvalidArgumentException;

class AuthorizedClients
{
    use CreatesPsr7Request;

    /**
     *
     * @var ClientValidatorInterface
     */
    private $clientsValidator;

    /**
     *
     * @var RequestClientReader
     */
    private $requestClientReader;

    /**
     *
     * @param ClientValidatorInterface $clientsValidator
     * @return self
     */
    public function __constuct(
        ClientValidatorInterface $clientsValidator,
        RequestClientReader $requestClientReader
    ) {
        $this->clientsValidator = $clientsValidator;
        $this->requestClientReader = $requestClientReader;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[] $scopes
     * @return mixed
     */
    public function handle($request, Closure $next, ...$scopes)
    {
        return $this->__invoke($request, null, $next, $scopes ?? []);
    }

    /**
     * Handles incoming request
     * 
     * @param mixed $request 
     * @param mixed $response 
     * @param mixed $next 
     * @param array $scopes 
     * @return mixed 
     * @throws InvalidArgumentException 
     * @throws UnAuthorizedClientException 
     */
    public function __invoke($request, $response, $next, $scopes = [])
    {
        $psr7Request = $this->psr7Request($request);
        [$client, $secret] = $this->requestClientReader->read($psr7Request);
        $this->clientsValidator->validate($client, $secret, $scopes, $this->ip($psr7Request));
        return null !== $response ? $next($request, $response) : $next($request);
    }
    
}
