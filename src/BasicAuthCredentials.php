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

use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Exceptions\DecodeTokenException;
use Drewlabs\Oauth\Clients\Exceptions\MalformedBasicAuthException;

class BasicAuthCredentials implements CredentialsIdentityInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * Creates class instance.
     */
    public function __construct(string $id, string $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    public function __toString(): string
    {
        return base64_encode(sprintf('%s:%s', $this->getId(), $this->getSecret()));
    }

    /**
     * Creates new instance from basic auth encoded string.
     *
     * @throws DecodeTokenException
     * @throws MalformedBasicAuthException
     *
     * @return static
     */
    public static function new(string $base64)
    {
        if (false === (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $base64)) {
            throw new DecodeTokenException($base64, sprintf("Error while decoding %s, is not a base64 encoded string\n", $base64));
        }

        if (false === ($decoded = base64_decode($base64, true))) {
            throw new DecodeTokenException($base64, sprintf('Error while decoding %s, is not a base64 encoded string', $base64));
        }

        if (false === ($offset = strpos($decoded, ':'))) {
            throw new MalformedBasicAuthException($decoded);
        }

        return new static(substr($decoded, 0, \strlen($decoded) - (\strlen($decoded) - $offset)), substr($decoded, $offset + 1));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
