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
 * This interface defines a functional interface for getting.
 */
interface ClientQueryInterface
{
    /**
     * query for clients using the provided identity parameter.
     *
     * @param CredentialsIdentityInterface|SecretIdentityInterface $identity
     *
     * @return ClientInterface|null
     */
    public function __invoke(CredentialsIdentityInterface $identity);
}
