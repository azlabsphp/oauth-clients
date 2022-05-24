<?php

namespace Drewlabs\AuthorizedClients\Contracts;

interface ScopedClient
{
    /**
     * Returns the list of scopes defines on the array
     * 
     * @return string[]|array 
     */
    public function getScopes();

    /**
     * 
     * @param Scope|string|string[] $scope
     * 
     * @return bool 
     */
    public function hasScope($scope);
    
}