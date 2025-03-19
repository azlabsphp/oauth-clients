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
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Contracts\ServerRequestFacade;
use Drewlabs\Oauth\Clients\Exceptions\InvalidTokenException;
use Drewlabs\Oauth\Clients\Exceptions\InvalidTokenSignatureException;
use Drewlabs\Oauth\Clients\Exceptions\TokenExpiresException;

class JwtCookieCredentialsFactory implements CredentialsFactoryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * @var ServerRequestFacade
     */
    private $serverRequest;

    /**
     * Create class instance.
     */
    public function __construct(ServerRequestFacade $serverRequest, string $key, string $name = 'jwt-cookie')
    {
        $this->serverRequest = $serverRequest;
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @param mixed $request
     *
     * @throws InvalidTokenException
     * @throws InvalidTokenSignatureException
     * @throws TokenExpiresException
     */
    public function create($request): ?CredentialsIdentityInterface
    {
        $jwtToken = $this->serverRequest->getRequestCookie($request, $this->name);

        // return a basic auth credential instance
        if ($jwtToken) {
            return JwtTokenCredentials::new($this->key, $jwtToken);
        }

        // we return null if base64 is null or false
        return null;
    }
}
