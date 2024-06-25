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

interface PlainTextSecretAware
{
    /**
     * @deprecated Use `getPlainSecret()` instead
     * 
     * @return string|null
     */
    public function getPlainSecretAttribute();


    /**
     * returns plain text secret key of the client
     * 
     * **Note** plain secret value is only available on newly created instances
     * 
     * @return null|string 
     */
    public function getPlainTextSecret(): ?string;
}
