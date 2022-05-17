<?php

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * 
 * @package Drewlabs\AuthorizedClients\Contracts
 */
interface ClientInterface
{

    /**
     * Returns the primary identifier of the client
     * 
     * @return string|int 
     */
    public function getKey();

    /**
     * Set the ip_addresses attribute of the client
     *
     * @param string|array $value
     * @return static
     */
    public function setIpAddressesAttribute($value);

    /**
     * Return the ip_addresses attributes of the client
     *
     * @return array
     */
    public function getIpAddressesAttribute();

    /**
     * Checks is the client is a first party client
     *
     * @return bool
     */
    public function firstParty();

    /**
     * Returns true if the client is revoked and false if not
     * 
     * @return bool 
     */
    public function isRevoked();


    /**
     * Returns the list of scopes defines on the array
     * 
     * @return string[]|array 
     */
    public function getScopes();
}
