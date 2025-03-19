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

/**
 * @mixin Validatable
 */
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
     */
    public function getName(): ?string;

    /**
     * Returns the user to which the client belongs to.
     *
     * @return string|int|null
     */
    public function getUserId();

    /**
     * returns the list of authorized ip addresses.
     */
    public function getIpAddresses(): array;

    /**
     * @deprecated Use `getIpAddresses()` instead
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

    /**
     * Returns a boolean value for whether the client is a password client or not.
     *
     * @return bool|null
     */
    public function isPasswordClient(): bool;

    /**
     * Returns a boolean value for whether the client is a password client or not.
     *
     * @return bool|null
     */
    public function isPersonalClient(): bool;

    /**
     * Return true if the client has secret attribute.
     */
    public function isConfidential(): bool;
}
