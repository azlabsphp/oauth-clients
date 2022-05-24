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
    private $hasMissingScopes = false;

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
        $self->hasMissingScopes = true;
        $self->missingScopes = $scopes;
        $self->client = $client;
        return $self;
    }

    /**
     * 
     * @return bool 
     */
    public function hasMissingScopes()
    {
        return null !== $this->hasMissingScopes ?
            boolval($this->hasMissingScopes) :
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
