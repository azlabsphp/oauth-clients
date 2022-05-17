<?php

namespace Drewlabs\AuthorizedClients;

use Drewlabs\AuthorizedClients\Contracts\ClientInterface;

/**
 * 
 * @package Drewlabs\AuthorizedClients
 */
class Client implements ClientInterface
{
    /**
     * List of class attributes
     * 
     * @var array
     */
    private $attributes = [];

    /**
     * Constructor function
     * 
     * @param array $attributes 
     * @return self 
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes ?? [];
    }

    public function getKey()
    {
        return $this->getAttribute('id');
    }

    public function setIpAddressesAttribute($value)
    {
        $this->attributes['ip_addresses'] = $value;
    }

    public function getIpAddressesAttribute()
    {
        return $this->getAttribute('ip_addresses');
    }

    public function firstParty()
    {
        return boolval($this->getAttribute('personal_access_client')) ||
            boolval($this->getAttribute('password_client'));
    }

    public function isRevoked()
    {
        return boolval($this->getAttribute('revoked'));
    }

    public function getScopes()
    {
        $scopes = $this->getAttribute('scopes');
        if (is_string($scopes)) {
            return json_decode($scopes);
        }
        return $scopes ?? [];
    }

    /**
     * 
     * @param string $key 
     * @return mixed 
     */
    private function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }
}
