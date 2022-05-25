<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * @method ClientInterface validate($clientId, $secret, $scopes = [], $requestIp = null)
 */
interface ClientValidatorInterface
{
    /**
     * @param string|int $clientId
     * @param string     $secret
     * @param array      $scopes
     * @param string     $requestIp
     *
     * @return ClientInterface
     */
    public function validate($clientId, $secret, $scopes = [], $requestIp = null);
}
