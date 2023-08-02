<?php

namespace Drewlabs\Oauth\Clients\Contracts;

use Closure;

interface ClientsRepository
{
    /**
     * Find a client instance using user id
     * 
     * @param mixed $identifier 
     */
    public function findByUserId($identifier): ClientInterface;

    /**
     * Find a client instance using `id` property
     * 
     * @param string|int $id
     *  
     * @return ClientInterface 
     */
    public function findById($id): ClientInterface;

    /**
     * Update client instance using `id` property
     * 
     * @param string|int $id 
     * @param NewClientInterface $attributes 
     * @param Closure|null $callback 
     * @return ClientInterface|mixed 
     */
    public function updateById($id, NewClientInterface $attributes, \Closure $callback = null);

    /**
     * Creates a new client instance
     * 
     * @param string|int $id 
     * @param NewClientInterface $attributes 
     * @param Closure|null $callback 
     * @return ClientInterface|mixed 
     */
    public function create(NewClientInterface $attributes, \Closure $callback = null);

    /**
     * Delete client using `id` property
     * 
     * @param string|int $id 
     * @param Closure|null $callback
     * 
     * @return bool 
     */
    public function deleteById($id, \Closure $callback = null);
}
