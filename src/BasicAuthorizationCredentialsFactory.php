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
use Drewlabs\Oauth\Clients\Contracts\ServerRequestFacade;

class BasicAuthorizationCredentialsFactory implements CredentialsFactoryInterface
{
    /**
     * @var ServerRequestFacade
     */
    private $serverRequest;

    /**
     * Create class instance
     * 
     * @param ServerRequestFacade $serverRequest 
     * @return void 
     */
    public function __construct(ServerRequestFacade $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }

    public function create($request)
    {
        $base64 = $this->serverRequest->getAuthorizationHeader($request, 'basic');

        // return a basic auth credential instance
        if ($base64) {
            return BasicAuthCredentials::new($base64);
        }

        return null;
    }
}
