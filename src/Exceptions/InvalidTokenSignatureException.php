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

namespace Drewlabs\Oauth\Clients\Exceptions;

class InvalidTokenSignatureException extends AuthorizationException
{
    /**
     * @var string
     */
    private $token;

    /**
     * creates class instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        parent::__construct('invalid token signature!');

        $this->token = $token;
    }

    /**
     * returns the token property value.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
