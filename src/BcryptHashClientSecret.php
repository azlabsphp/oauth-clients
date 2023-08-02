<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\HashesClientSecret;

class BcryptHashClientSecret implements HashesClientSecret
{
    /**
     * @var array
     */
    private $options;

    /**
     * Create class instance
     * 
     * @param array $options 
     */
    public function __construct(array $options = [])
    {
        $this->options = $options ?? [];
    }

    public function hashSecret(string $plainText)
    {
        return password_hash($plainText, PASSWORD_BCRYPT, $this->options ?? []);
    }
}
