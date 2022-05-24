<?php

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * Type definition for complex scope implementation
 * 
 * @package Drewlabs\AuthorizedClients\Contracts
 */
interface Scope
{

    /**
     * Returns the string representation of the scope object
     * 
     * @return string 
     */
    public function __toString();

}