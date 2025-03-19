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

interface NewClientInterface
{
    /**
     * Returns client `id` property for existing clients.
     */
    public function getId(): ?string;

    /**
     * Returns app client name value.
     */
    public function getName(): ?string;

    /**
     * Returns client user id value.
     */
    public function getUserId(): ?string;

    /**
     * Returns client redirect url value.
     */
    public function getRedirectUrl(): ?string;

    /**
     * Returns client provider value.
     */
    public function getProvider(): ?string;

    /**
     * Returns client authorized ip address value.
     */
    public function getIpAddresses(): ?array;

    /**
     * Returns client authorization secret value.
     */
    public function getSecret(): ?string;

    /**
     * Returns client app host url value.
     */
    public function getAppUrl(): ?string;

    /**
     * Returns a boolean value indicating if client is revoked or not.
     */
    public function getRevoked(): ?bool;

    /**
     * Returns client expiration date time string.
     */
    public function getExpiresAt(): ?string;

    /**
     * Return list of client scopes.
     */
    public function getScopes(): ?array;

    /**
     * Returns a boolean value for whether the client is a password client or not.
     */
    public function isPasswordClient(): ?bool;

    /**
     * Returns a boolean value for whether the client is a password client or not.
     */
    public function isPersonalClient(): ?bool;
}
