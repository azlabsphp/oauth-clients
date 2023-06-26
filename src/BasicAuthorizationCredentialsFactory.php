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

use Drewlabs\AuthorizedClients\Contracts\CredentialsFactory;
use Drewlabs\AuthorizedClients\Exceptions\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;

class BasicAuthorizationCredentialsFactory implements CredentialsFactory
{
    use InteractWithServerRequest;

    public function create(ServerRequestInterface $request)
    {
        $base64 = $this->getHeader($request, 'authorization', 'basic');

        // return a basic auth credential instance
        if ($base64) {
            return BasicAuthCredentials::new($base64);
        }

        // throw not found exception if base64 is null or false
        throw new AuthorizationException('basic auth string not found');
    }
}
