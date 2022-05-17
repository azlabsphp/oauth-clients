<?php

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * This interface defines a functional interface for getting
 * 
 * @package Drewlabs\AuthorizedClients\Contracts
 */
interface ClientSelector
{
    /**
     * Functional
     * 
     * @param string|int $clientId 
     * @param string $secret 
     * @return ClientInterface|null 
     */
    public function __invoke($clientId, $secret);

}