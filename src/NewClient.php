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

use Drewlabs\Oauth\Clients\Contracts\NewClientInterface;

class NewClient implements NewClientInterface, \JsonSerializable
{
    /**
     * List of class attributes.
     *
     * @var array
     */
    private $attributes = [];

    /**
     * @var bool
     */
    private $isPersonalClient = false;

    /**
     * @var bool
     */
    private $isPasswordClient = false;

    /**
     * @var string|int
     */
    private $id;

    /**
     * Creates class instance.
     *
     * @param string|int $id
     * @param bool       $isPersonalClient
     * @param bool       $isPasswordClient
     *
     * @return void
     */
    public function __construct($id = null, bool $isPersonalClient = null, bool $isPasswordClient = null)
    {
        $this->id = null !== $id ? (string) $id : $id;
        $this->isPersonalClient = $isPersonalClient;
        $this->isPasswordClient = $isPasswordClient;
        $this->attributes = [];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Set `name` property value.
     *
     * @return static
     */
    public function setName(string $value = null)
    {
        $this->setAttribute('name', $value);

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->getAttribute('user_id');
    }

    /**
     * Set `user id` property value.
     *
     * @return static
     */
    public function setUserId(string $value = null)
    {
        $this->setAttribute('user_id', $value);

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->getAttribute('redirect');
    }

    /**
     * Set `redirect` property value.
     *
     * @return static
     */
    public function setRedirectUrl(string $value = null)
    {
        $this->setAttribute('redirect', $value);

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->getAttribute('provider');
    }

    /**
     * Set `provider` property value.
     *
     * @return static
     */
    public function setProvider(string $value = null)
    {
        $this->setAttribute('provider', $value);

        return $this;
    }

    public function getIpAddresses(): ?array
    {
        return $this->getAttribute('ip_addresses');
    }

    /**
     * Set `ip addresses` property value.
     *
     * @return static
     */
    public function setIpAddresses(array $value = null)
    {
        $this->setAttribute('ip_addresses', $value);

        return $this;
    }

    public function getSecret(): ?string
    {
        return $this->getAttribute('secret');
    }

    /**
     * Set `secret` property value.
     *
     * @return static
     */
    public function setSecret(string $value = null)
    {
        $this->setAttribute('secret', $value);

        return $this;
    }

    public function getAppUrl(): ?string
    {
        return $this->getAttribute('client_url');
    }

    /**
     * Set `app url` property value.
     *
     * @return static
     */
    public function setAppUrl(string $value = null)
    {
        $this->setAttribute('client_url', $value);

        return $this;
    }

    public function getRevoked(): ?bool
    {
        return (bool) $this->getAttribute('revoked');
    }

    /**
     * Set `revoked` property value.
     *
     * @return static
     */
    public function setRevoked(bool $value = null)
    {
        $this->setAttribute('revoked', $value);

        return $this;
    }

    public function getExpiresAt(): ?string
    {
        return $this->getAttribute('expires_on');
    }

    /**
     * Set client `expires on` property value.
     *
     * @return static
     */
    public function setExpiresAt(string $value = null)
    {
        $this->setAttribute('expires_on', $value);

        return $this;
    }

    public function getScopes(): ?array
    {
        return $this->getAttribute('scopes');
    }

    /**
     * Set `ip addresses` property value.
     *
     * @return static
     */
    public function setScopes(array $value = null)
    {
        $this->setAttribute('scopes', $value);

        return $this;
    }

    public function isPasswordClient(): ?bool
    {
        return $this->isPasswordClient;
    }

    public function isPersonalClient(): ?bool
    {
        return $this->isPersonalClient;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Return an attribute value if exists or `null` if not exists.
     *
     * @return mixed|null
     */
    private function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Set value for a `$name` attributes.
     *
     * @param mixed $value
     *
     * @return void
     */
    private function setAttribute(string $name, $value)
    {
        if (null === $value) {
            return;
        }
        $this->attributes[$name] = $value;
    }
}
