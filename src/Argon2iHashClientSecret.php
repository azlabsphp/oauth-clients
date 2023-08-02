<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\HashesClientSecret;

class Argon2iHashClientSecret implements HashesClientSecret
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
        return password_hash($plainText, PASSWORD_ARGON2I, $this->options ?? []);
    }
}
