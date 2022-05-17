<?php

namespace Drewlabs\AuthorizedClients\Exceptions;

use Exception;

class UnAuthorizedClientException extends Exception
{
    /**
     * 
     * @var array
     */
    private $missingScopes = [];

    /**
     * 
     * @var bool
     */
    private $hasScopesError = false;

    /**
     * 
     * @var string
     */
    private $client;

    /**
     * 
     * @param string|int $client 
     * @param array $scopes 
     * @return UnAuthorizedClientException 
     */
    public static function forScopes($client, array $scopes = [])
    {
        $self = new self('Client does not have required scopes.');
        $self->hasScopesError = true;
        $self->missingScopes = $scopes;
        $self->client = $client;
        return $self;
    }

    /**
     * 
     * @return bool 
     */
    public function hasScopesError()
    {
        return null !== $this->hasScopesError ?
            boolval($this->hasScopesError) :
            false;
    }

    /**
     * 
     * @return array 
     */
    public function getMissingScopes()
    {
        return $this->missingScopes ?? [];
    }

    /**
     * 
     * @return string|int
     */
    public function getClient()
    {
        return $this->client;
    }
}
