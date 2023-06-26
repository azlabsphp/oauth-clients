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

use Drewlabs\AuthorizedClients\Contracts\CredentialsIdentityInterface;

class Credentials implements CredentialsIdentityInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * Creates class instance.
     */
    public function __construct(string $id, string $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    public function __toString(): string
    {
        return sprintf('%s:%s', $this->getId(), $this->getSecret());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
