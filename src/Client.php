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

use Drewlabs\Oauth\Clients\Contracts\ApiKeyAware;
use Drewlabs\Oauth\Clients\Contracts\AttributesAware;
use Drewlabs\Oauth\Clients\Contracts\ClientInterface;
use Drewlabs\Oauth\Clients\Contracts\GrantTypesAware;
use Drewlabs\Oauth\Clients\Contracts\PlainTextSecretAware;
use Drewlabs\Oauth\Clients\Contracts\RedirectUrlAware;
use Drewlabs\Oauth\Clients\Contracts\ScopeInterface;
use Drewlabs\Oauth\Clients\Contracts\Validatable;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;
use Drewlabs\Oauth\Clients\Exceptions\MissingScopesException;

class Client implements ClientInterface, GrantTypesAware, PlainTextSecretAware, RedirectUrlAware, ApiKeyAware, Validatable
{
    /**  @var AttributesAware */
    private $base;

    /** @var string|null */
    private $plainTextSecret;

    /**
     * Create client instance.
     */
    public function __construct(AttributesAware $base, string $plainTextSecret = null)
    {
        $this->base = $base;
        $this->plainTextSecret = $plainTextSecret;
    }

    public function validate(array $scopes = [], ?string $ip = null): bool
    {

        // Case the client is revoked, we throw an authorization exception
        if ($this->isRevoked()) {
            throw new AuthorizationException('client has been revoked');
        }

        // Case the client is a first party client, we do not check for
        // ip address as first party clients are intended to have administration privilege
        // and should not be used by third party applications
        if ($this->firstParty()) {
            return true;
        }

        // Case client does not have the required scopes we throw a Missing scope exception
        if (!$this->hasScope($scopes)) {
            $scopes = $scopes instanceof ScopeInterface ? (string) $scopes : $scopes;
            $scopes = \is_string($scopes) ? [$scopes] : $scopes;
            throw new MissingScopesException($this->getKey(), array_diff($this->getScopes(), $scopes));
        }

        // Provide the client request headers in the proxy request headers definition Get Client IP Addresses
        $ips = null !== ($ips = $this->getIpAddresses()) ? $ips : [];

        // Check whether * exists in the list of client ips
        if (!\in_array('*', $ips, true) && (null !== $ip)) {
            // // Return the closure handler for the next middleware
            // Get the request IP address
            if (!\in_array($ip, $ips, true)) {
                throw new AuthorizationException(sprintf('unauthorized request origin %s', \is_array($ip) ? implode(',', $ip) : $ip));
            }
        }

        return true;
    }

    public function getApiKey(): ?string
    {
        return $this->base->getAttribute('api_key');
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
        return $this->getPlainTextSecret();
    }

    public function getPlainTextSecret(): ?string
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
        return $this->getIpAddresses();
    }
    public function getIpAddresses(): array
    {
        $values = $this->base->getAttribute('ip_addresses');
        return \is_string($values) ? explode(',', $values) : (array) $values;
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
