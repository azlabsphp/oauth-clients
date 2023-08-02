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

interface SecretIdentityInterface
{
    /**
     * returns the string representation of the identity instance.
     */
    public function __toString(): string;

    /**
     * returns the secret value from of the identity instance.
     */
    public function getSecret(): string;
}
