<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\SecretClientInterface;
use Drewlabs\Oauth\Clients\Contracts\VerifyClientSecretInterface;

class VerifyPlainTextSecretEngine implements VerifyClientSecretInterface
{
    public function verify(SecretClientInterface $client, string $secret)
    {
        return 0 === strcmp($client->getHashedSecret(), $secret);
    }
}
