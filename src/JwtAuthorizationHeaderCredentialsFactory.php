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

class JwtAuthorizationHeaderCredentialsFactory implements CredentialsFactoryInterface
{
    /**
     * @var ServerRequestFacade
     */
    private $serverRequest;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $key;

    /**
     * Create class instance.
     */
    public function __construct(ServerRequestFacade $serverRequest, string $key, string $method = 'jwt')
    {
        $this->serverRequest = $serverRequest;
        $this->method = $method;
        $this->key = $key;
    }

    public function create($request): ?CredentialsIdentityInterface
    {
        $jwtToken = $this->serverRequest->getAuthorizationHeader($request, $this->method);

        // return a basic auth credential instance
        if ($jwtToken) {
            return JwtTokenCredentials::new($this->key, $jwtToken);
        }

        // We return null case the jwt token is not found
        return null;
    }
}
