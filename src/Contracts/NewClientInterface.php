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
     * returns client `id` property for existing clients.
     */
    public function getId(): ?string;

    /**
     * returns app client name value.
     */
    public function getName(): ?string;

    /**
     * returns client user id value.
     */
    public function getUserId(): ?string;

    /**
     * returns client redirect url value.
     */
    public function getRedirectUrl(): ?string;

    /**
     * returns client provider value.
     */
    public function getProvider(): ?string;

    /**
     * returns client authorized ip address value.
     */
    public function getIpAddresses(): ?array;

    /**
     * returns client authorization secret value.
     */
    public function getSecret(): ?string;

    /**
     * returns client app host url value.
     */
    public function getAppUrl(): ?string;

    /**
     * returns a boolean value indicating if client is revoked or not.
     */
    public function getRevoked(): ?bool;

    /**
     * returns client expiration date time string.
     */
    public function getExpiresAt(): ?string;

    /**
     * Return list of client scopes.
     */
    public function getScopes(): ?array;

    /**
     * returns a boolean value for whether the client is a password client or not.
     */
    public function isPasswordClient(): ?bool;

    /**
     * returns a boolean value for whether the client is a password client or not.
     */
    public function isPersonalClient(): ?bool;
}
