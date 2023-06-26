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

namespace Drewlabs\AuthorizedClients;

use Drewlabs\AuthorizedClients\Contracts\SecretIdentityInterface;

class ApiToken implements SecretIdentityInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * Creates class instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __toString(): string
    {
        return (string) $this->token;
    }

    public function getSecret(): string
    {
        return $this->__toString();
    }
}
