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


class Base64URLDecode
{

    public function __construct()
    {
    }

    /**
     * Functional interface to decode a base64 url encoded string
     * @param string $data 
     * @return string 
     */
    public function __invoke(string $base64): string
    {
        return $this->call($base64);
    }

    /**
     * return a decoded base64 url encoded string
     * 
     * @param string $data 
     * @return string 
     */
    public function call(string $base64): string
    {
        return base64_decode(strtr($base64, '-_', '+/'));
    }

}