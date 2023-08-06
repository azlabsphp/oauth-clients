<?php

declare(strict_types=1);

/*
 * This file is part of the drewlabs namespace.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
