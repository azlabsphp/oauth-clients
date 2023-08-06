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

namespace Drewlabs\Oauth\Clients\Contracts;

interface VerifyClientSecretInterface
{
    /**
     * Check client hashed secret against provided `$secret` parameter.
     *
     * @return bool
     */
    public function verify(SecretClientInterface $client, string $secret);
}
