<?php

namespace Drewlabs\Oauth\Clients\Contracts;

interface ApiKeyAware
{
    /**
     * returns `api_key` property value if provided or null if not provided
     * 
     * @return null|string 
     */
    public function getApiKey(): ?string;
}