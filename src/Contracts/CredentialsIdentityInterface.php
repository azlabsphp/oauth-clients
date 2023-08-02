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

interface CredentialsIdentityInterface extends SecretIdentityInterface
{
    /**
     * returns `id` of the credentials instance.
     *
     * @return string|int
     */
    public function getId();
}
