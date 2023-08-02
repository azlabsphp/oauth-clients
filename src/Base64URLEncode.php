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

class Base64URLEncode
{
    public function __construct()
    {
    }

    /**
     * Functional interface to compute a base64 url encoded string.
     */
    public function __invoke(string $data): string
    {
        return $this->call($data);
    }

    /**
     * return a base64 url encoded string.
     */
    public function call(string $data): string
    {
        $base64Url = strtr(base64_encode($data), '+/', '-_');

        return rtrim($base64Url, '=');
    }
}
