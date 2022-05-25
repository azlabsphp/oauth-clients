<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\AuthorizedClients\Exceptions;

class UnAuthorizedClientException extends \Exception
{
    /**
     * @var array
     */
    private $missingScopes = [];

    /**
     * @var bool
     */
    private $hasMissingScopes = false;

    /**
     * @var string
     */
    private $client;

    /**
     * @param string|int $client
     *
     * @return UnAuthorizedClientException
     */
    public static function forScopes($client, array $scopes = [])
    {
        $self = new self('Client does not have required scopes.');
        $self->hasMissingScopes = true;
        $self->missingScopes = $scopes;
        $self->client = $client;

        return $self;
    }

    /**
     * @return bool
     */
    public function hasMissingScopes()
    {
        return null !== $this->hasMissingScopes ?
            (bool) ($this->hasMissingScopes) :
            false;
    }

    /**
     * @return array
     */
    public function getMissingScopes()
    {
        return $this->missingScopes ?? [];
    }

    /**
     * @return string|int
     */
    public function getClient()
    {
        return $this->client;
    }
}
