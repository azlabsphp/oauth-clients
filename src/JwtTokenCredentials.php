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
use Drewlabs\Oauth\Clients\Exceptions\InvalidTokenException;
use Drewlabs\Oauth\Clients\Exceptions\InvalidTokenSignatureException;
use Drewlabs\Oauth\Clients\Exceptions\TokenExpiresException;

class JwtTokenCredentials implements CredentialsIdentityInterface
{
    /**
     * @var string
     */
    public const ALGO = 'sha256';

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * creates class instance.
     *
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __toString(): string
    {
        if (empty($this->getId()) || empty($this->getSecret())) {
            throw new \BadMethodCallException('withPayload() must be called before creating the jwt token');
        }
        $payload = sprintf('%s.%s', (string) (new JwtHeader('HS256', 'JWT')), (string) (new JwtPayload(['sub' => $this->getId(), 'jit' => $this->getSecret(), 'expires_at' => (new \DateTimeImmutable())->modify(sprintf('+ %d seconds', $this->getTTL()))->format('YmdHis')])));

        return sprintf('%s.%s', $payload, static::createSignature($payload, static::ALGO, $this->key));
    }

    /**
     * creates a new jwt credentials instance from jwt token string.
     *
     * @return static
     */
    public static function new(string $key, string $token)
    {
        $components = explode('.', $token);

        if (3 !== \count($components)) {
            // TODO: Throw InvalidTokenException
            throw new InvalidTokenException($token);
        }

        [$header, $payload, $signature] = $components;

        // #region jwt header and payload
        $jwtHeader = JwtHeader::decode($header);
        $jwtPayload = JwtPayload::decode($payload);
        // #endregion jwt header and payload

        if (!$jwtPayload->isset('sub') || !$jwtPayload->isset('expires_at') || !\is_string($expiresAt = $jwtPayload->getAttribute('expires_at'))) {
            // TODO: throw an invalid token
            throw new InvalidTokenException($token);
        }

        // Validate jwt header
        if ('HS256' !== $jwtHeader->getAlg() || 'JWT' !== $jwtHeader->getTyp()) {
            // TODO : thow InvalidTokenException
            throw new InvalidTokenException($token);
        }

        // TODO: Check if the token signature is valid
        $payload = sprintf('%s.%s', (string) $jwtHeader, (string) $jwtPayload);

        // TODO: Make sure the signature is created with right algo
        if (!hash_equals(static::createSignature($payload, static::ALGO, $key), $signature)) {
            // TODO : throw TokenSiganatureException
            throw new InvalidTokenSignatureException($token);
        }

        // Check if the token has expired
        $isPast = \DateTimeImmutable::createFromFormat('YmdHis', $expiresAt) < new \DateTimeImmutable();

        if ($isPast) {
            // TODO : throw TokenExpiresException
            throw new TokenExpiresException($token);
        }

        return (new static($key))->withPayload($jwtPayload->getAttribute('sub'), $jwtPayload->getAttribute('jit'));
    }

    /**
     * Add payload to the jwt credentials instance.
     *
     * **Note** Method is immutable
     *
     * @return static
     */
    public function withPayload(string $id, string $secret)
    {
        // make the method immutable by cloning the instance
        $self = clone $this;

        // Set the id attribute of the payload
        $self->setId($id);

        // Set the secret attribute of the payload
        $self->setSecret($secret);

        // return the constructed instance
        return $self;
    }

    /**
     * creates the token string with a ttl value.
     *
     * **Note** Method is an immutable implementation
     *
     * @return static
     */
    public function withTTL(int $seconds)
    {
        $self = clone $this;

        $self->ttl = $seconds;

        return $self;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret(): string
    {
        return $this->secret ?? '';
    }

    /**
     * `id` property setter.
     *
     * @return void
     */
    private function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * `secret property setter`.
     *
     * @return void
     */
    private function setSecret(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * return the token ttl.
     *
     * @return int
     */
    private function getTTL()
    {
        return $this->ttl ?? 60 * 60 * 24;
    }

    /**
     * create jwt signature.
     *
     * @return string
     */
    private static function createSignature(string $payload, string $algo, string $key)
    {
        return (new Base64URLEncode())(hash_hmac($algo, $payload, $key));
    }
}
