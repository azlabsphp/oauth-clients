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

use Drewlabs\Oauth\Clients\Contracts\CredentialsFactoryInterface;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;

class JwtCookieCredentialsFactory implements CredentialsFactoryInterface
{
    use InteractWithServerRequest;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * creates class instance.
     */
    public function __construct(string $key, string $name = 'jwt-cookie')
    {
        $this->name = $name;
        $this->key = $key;
    }

    public function create(ServerRequestInterface $request)
    {
        $cookies = $request->getCookieParams();

        $jwtToken = $cookies[$this->name] ?? null;

        // return a basic auth credential instance
        if ($jwtToken) {
            return JwtTokenCredentials::new($this->key, $jwtToken);
        }

        // throw not found exception if base64 is null or false
        throw new AuthorizationException('jwt auth string not found');
    }
}
