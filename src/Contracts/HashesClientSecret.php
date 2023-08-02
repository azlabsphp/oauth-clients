<?php

namespace Drewlabs\Oauth\Clients\Contracts;

interface HashesClientSecret
{
    /**
     * hashes client secret using a hasing algorithm
     * 
     * @param string $plainText
     * 
     * @return string 
     */
    public function hashSecret(string $plainText);

}