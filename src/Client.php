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

use Drewlabs\Oauth\Clients\Contracts\AttributesAware;
use Drewlabs\Oauth\Clients\Contracts\ClientInterface;
use Drewlabs\Oauth\Clients\Contracts\GrantTypesAware;
use Drewlabs\Oauth\Clients\Contracts\PlainTextSecretAware;
use Drewlabs\Oauth\Clients\Contracts\RedirectUrlAware;
use Drewlabs\Oauth\Clients\Contracts\ScopeInterface;

class Client implements ClientInterface, GrantTypesAware, PlainTextSecretAware, RedirectUrlAware
{
    /**
     * @var AttributesAware
     */
    private $base;

    /**
     * @var string|null
     */
    private $plainTextSecret;

    /**
     * Create client instance.
     */
    public function __construct(AttributesAware $base, string $plainTextSecret = null)
    {
        $this->base = $base;
        $this->plainTextSecret = $plainTextSecret;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->base->getAttribute('redirect');
    }

    public function getGrantTypes(): array
    {
        $grantTypes = $this->base->getAttribute('grant_types');

        return \is_string($grantTypes) ? explode(',', $grantTypes) : (array) $grantTypes;
    }

    public function getHashedSecret()
    {
        return $this->base->getAttribute('secret');
    }

    public function getPlainSecretAttribute()
    {
        return $this->plainTextSecret;
    }

    public function getName(): ?string
    {
        return $this->base->getAttribute('name');
    }

    public function getUserId()
    {
        return $this->base->getAttribute('user_id');
    }

    public function getKey()
    {
        return $this->base->getAttribute('id');
    }

    public function getIpAddressesAttribute()
    {
        return $this->base->getAttribute('ip_addresses');
    }

    public function firstParty()
    {
        return (bool) $this->base->getAttribute('personal_access_client') || (bool) $this->base->getAttribute('password_client');
    }

    public function isRevoked()
    {
        return (bool) $this->base->getAttribute('revoked');
    }

    public function getScopes(): array
    {
        if (\is_string($scopes = $this->base->getAttribute('scopes'))) {
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

    public function isPasswordClient(): bool
    {
        return (bool) $this->base->getAttribute('password_client');
    }

    public function isPersonalClient(): bool
    {
        return (bool) $this->base->getAttribute('personal_access_client');
    }

    public function isConfidential(): bool
    {
        return null !== $this->base->getAttribute('personal_access_client') && !empty($this->getHashedSecret());
    }
}
