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

namespace Drewlabs\Oauth\Clients\Contracts;

interface ClientInterface
{
    /**
     * Returns the primary identifier of the client.
     *
     * @return string|int
     */
    public function getKey();

    /**
     * Returns the client name property or attribute.
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Returns the user to which the client belongs to.
     *
     * @return string|int|null
     */
    public function getUserId();

    /**
     * Set the ip_addresses attribute of the client.
     *
     * @param string|array $value
     *
     * @return static
     */
    public function setIpAddressesAttribute($value);

    /**
     * Return the ip_addresses attributes of the client.
     *
     * @return array
     */
    public function getIpAddressesAttribute();

    /**
     * check if the client is a first party client.
     *
     * @return bool
     */
    public function firstParty();

    /**
     * returns true if the client is revoked and false if not.
     *
     * @return bool
     */
    public function isRevoked();

    /**
     * returns the list of scopes defines on the array.
     *
     * @return string[]|array
     */
    public function getScopes(): array;

    /**
     * checks if client has a given scope.
     *
     * @param ScopeInterface|string|string[] $scope
     */
    public function hasScope($scope): bool;
}
