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

class MissingScopesException extends AuthorizationException
{
    /**
     * @var array
     */
    private $scopes = [];

    /**
     * @var mixed
     */
    private $client;

    /**
     * Creates exception class instance.
     *
     * @param string|int $client
     *
     * @return AuthorizationException
     */
    public function __construct($client, array $scopes = [])
    {
        parent::__construct('Client does not have required scopes.');
        $this->scopes = $scopes;
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes ?? [];
    }

    /**
     * @return string|int
     */
    public function getClient()
    {
        return $this->client;
    }
}
