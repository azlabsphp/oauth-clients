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

use Drewlabs\AuthorizedClients\Contracts\CredentialsFactoryInterface;
use Drewlabs\AuthorizedClients\Exceptions\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;

class JwtAuthorizationHeaderCredentialsFactory implements CredentialsFactoryInterface
{
    use InteractWithServerRequest;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $key;

    /**
     * creates class instance
     * 
     * @param string $method 
     */
    public function __construct(string $key, string $method = 'jwt')
    {
        $this->method = $method;
        $this->key = $key;
    }

    public function create(ServerRequestInterface $request)
    {
        $jwtToken = $this->getHeader($request, 'authorization', $this->method);

        // return a basic auth credential instance
        if ($jwtToken) {
            return JwtTokenCredentials::new($this->key, $jwtToken);
        }

        // throw not found exception if base64 is null or false
        throw new AuthorizationException('jwt auth string not found');
    }
}
