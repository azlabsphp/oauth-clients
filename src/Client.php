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

use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\Contracts\ScopeInterface;

class Client implements ClientInterface
{
    /**
     * List of class attributes.
     *
     * @var array
     */
    private $attributes = [];

    /**
     * Creates class instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes ?? [];
    }

    public function getUserID()
    {
        return $this->getAttribute('user_id');
    }

    public function getKey()
    {
        return $this->getAttribute('id');
    }

    public function setIpAddressesAttribute($value)
    {
        $this->attributes['ip_addresses'] = $value;
    }

    public function getIpAddressesAttribute()
    {
        return $this->getAttribute('ip_addresses');
    }

    public function firstParty()
    {
        return (bool) $this->getAttribute('personal_access_client') || (bool) $this->getAttribute('password_client');
    }

    public function isRevoked()
    {
        return (bool) $this->getAttribute('revoked');
    }

    public function getScopes(): array
    {
        if (\is_string($scopes = $this->getAttribute('scopes'))) {
            return json_decode($scopes, true);
        }

        return $scopes ?? [];
    }

    public function hasScope($scope): bool
    {
        $clientScopes = $this->getScopes() ?? ['*'];
        if (\in_array('*', $clientScopes, true)) {
            return true;
        }
        if (empty($scope)) {
            return true;
        }
        if ($scope instanceof ScopeInterface) {
            $scope = (string) $scope;
        }

        return !empty(array_intersect(\is_string($scope) ? [$scope] : $scope, $clientScopes ?? []));
    }

    /**
     * Provides an interface for resolving attributes from `$attributes` array.
     *
     * @return mixed
     */
    private function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }
}
