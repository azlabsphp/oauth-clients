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

/**
 * @method ClientInterface validate($clientId, $secret, $scopes = [], $requestIp = null)
 */
interface CredentialsIdentityValidator
{
    /**
     * validate provided client id against the client secret, scopes and request ip address.
     *
     * @param array  $scopes
     * @param string $ip
     *
     * @return ClientInterface
     */
    public function validate(CredentialsIdentityInterface $credentials, $scopes = [], $ip = null);
}
