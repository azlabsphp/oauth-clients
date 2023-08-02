<?php

namespace Drewlabs\Oauth\Clients;

use Drewlabs\Oauth\Clients\Contracts\VerifyClientSecretInterface;
use Drewlabs\Oauth\Clients\Contracts\SecretClientInterface;

class PasswordVerifyClientSecretEngine implements VerifyClientSecretInterface
{
    public function verify(SecretClientInterface $client, string $secret)
    {
        return password_verify($secret, $client->getHashedSecret());
    }
}
