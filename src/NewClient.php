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
use JsonSerializable;

class NewClient implements NewClientInterface, JsonSerializable
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
    public function __construct()
    {
        $this->attributes = [];
    }

    public function getName(): ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Set `name` property value
     * 
     * @param string|null $value
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
     * Set `user id` property value
     * 
     * @param string|null $value
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
     * Set `redirect` property value
     * 
     * @param string|null $value
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
     * Set `provider` property value
     * 
     * @param string|null $value
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
     * Set `ip addresses` property value
     * 
     * @param array|null $value
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
     * Set `secret` property value
     * 
     * @param string|null $value
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
     * Set `app url` property value
     * 
     * @param string|null $value
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
        return boolval($this->getAttribute('revoked'));
    }

    /**
     * Set `revoked` property value
     * 
     * @param bool|null $value
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
     * Set client `expires on` property value
     * 
     * @param string|null $value
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
     * Set `ip addresses` property value
     * 
     * @param array|null $value
     * 
     * @return static 
     */
    public function setScopes(array $value = null)
    {
        $this->setAttribute('scopes', $value);

        return $this;
    }

    /**
     * Return an attribute value if exists or `null` if not exists
     * 
     * @param string $name 
     * @return mixed|null
     */
    private function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Set value for a `$name` attributes
     *  
     * @param string $name 
     * @param mixed $value 
     * @return void 
     */
    private function setAttribute(string $name, $value)
    {
        if (null === $value) {
            return;
        }
        $this->attributes[$name] = $value;
    }

    /**
     * 
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
}
