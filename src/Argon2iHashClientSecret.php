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

use Drewlabs\Oauth\Clients\Contracts\HashesClientSecret;

class Argon2iHashClientSecret implements HashesClientSecret
{
    /**  @var array */
    private $options;

    /**
     * Create class instance.
     */
    public function __construct(array $options = [])
    {
        $this->options = $options ?? [];
    }

    public function hashSecret(string $plainText)
    {
        return password_hash($plainText, \PASSWORD_ARGON2I, $this->options ?? []);
    }
}
