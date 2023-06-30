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

namespace Drewlabs\AuthorizedClients\Exceptions;

use Drewlabs\AuthorizedClients\Exceptions\AuthorizationException;

class TokenExpiresException extends AuthorizationException
{
    /**
     * @var string
     */
    private $token;

    /**
     * creates class instance
     * 
     * @param string $token
     * 
     * @return void 
     */
    public function __construct(string $token)
    {
        parent::__construct('Token has expire!');

        $this->token = $token;
    }


    /**
     * returns the token property value
     * 
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}