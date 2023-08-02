<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\HashesClientSecret;

class PlainTextHashClientSecret implements HashesClientSecret
{
    public function hashSecret(string $plainText)
    {
        return $plainText;
    }
}
