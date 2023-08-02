<?php

namespace Drewlabs\Oauth\Clients\Contracts;

interface NewClientInterface
{
    /**
     * Returns app client name value
     * 
     * @return null|string 
     */
    public function getName(): ?string;

    /**
     * Returns client user id value
     * 
     * @return null|string 
     */
    public function getUserId(): ?string;

    /**
     * Returns client redirect url value
     * 
     * @return null|string 
     */
    public function getRedirectUrl(): ?string;

    /**
     * Returns client provider value
     * 
     * @return string 
     */
    public function getProvider(): ?string;

    /**
     * Returns client authorized ip address value
     * 
     * @return array 
     */
    public function getIpAddresses(): ?array;

    /**
     * Returns client authorization secret value
     * 
     * @return null|string 
     */
    public function getSecret(): ?string;

    /**
     * Returns client app host url value
     * 
     * @return null|string 
     */
    public function getAppUrl(): ?string;

    /**
     * Returns a boolean value indicating if client is revoked or not
     * 
     * @return null|bool 
     */
    public function getRevoked(): ?bool;

    /**
     * Returns client expiration date time string
     * 
     * @return null|string 
     */
    public function getExpiresAt(): ?string;

    /**
     * Return list of client scopes
     * 
     * @return array 
     */
    public function getScopes(): ?array;
}
