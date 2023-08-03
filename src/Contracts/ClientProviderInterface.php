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

interface ClientProviderInterface
{
    /**
     * query for clients using the provided identity parameter.
     *
     * @param CredentialsIdentityInterface|SecretIdentityInterface $credentials
     *
     * @return ClientInterface|null
     */
    public function __invoke(CredentialsIdentityInterface $credentials);

    /**
     * Find oauth client via credentials object
     * 
     * @param CredentialsIdentityInterface|SecretIdentityInterface $credentials
     * 
     * @return ClientInterface|null 
     */
    public function findByCredentials(CredentialsIdentityInterface $credentials): ?ClientInterface;
}
