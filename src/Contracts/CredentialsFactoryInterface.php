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

use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;

interface CredentialsFactoryInterface
{
    /**
     * Returns a (client, secret) tuple from provided request.
     *
     * @throws AuthorizationException
     *
     * @return CredentialsIdentityInterface|SecretIdentityInterface
     */
    public function create(ServerRequestInterface $request);
}
