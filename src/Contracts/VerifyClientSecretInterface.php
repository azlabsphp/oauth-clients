<?php

namespace Drewlabs\Oauth\Clients\Contracts;

interface VerifyClientSecretInterface
{
    /**
     * Check client hashed secret against provided `$secret` parameter
     * 
     * @param SecretClientInterface $client 
     * @param string $secret
     *  
     * @return bool 
     */
    public function verify(SecretClientInterface $client,string $secret);
}
