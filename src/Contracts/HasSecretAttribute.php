<?php

namespace Drewlabs\AuthorizedClients\Contracts;

interface HasSecretAttribute
{

    /**
     * Return the token property of the client model
     *
     * @return string
     */
    public function getSecretAttribute();

    /**
     * Set the property of the model to control whether the token is fully loaded or not
     *
     * @param bool $value
     * @return static
     */
    public function showPlainSecret($value = true);


    /**
     * Verify if client secret matches
     * 
     * @param string $secret
     * 
     * @return bool 
     */
    public function validateSecret(string $secret);
}
