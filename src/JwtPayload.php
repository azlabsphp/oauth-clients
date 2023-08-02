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

class JwtPayload
{
    /**
     * @var array<string, mixed>
     */
    private $attributes;

    /**
     * creates class instance.
     *
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * returns the encoded string of the current class.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->encode();
    }

    /**
     * get the actual jwt payloaf.
     *
     * @return array<string, mixed>
     */
    public function getValue()
    {
        return $this->attributes;
    }

    /**
     * get payload value using payload name.
     *
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * checks if the name attribute isset in the jwt payload.
     *
     * @return bool
     */
    public function isset(string $name)
    {
        return \array_key_exists($name, $this->attributes) && null !== $this->attributes[$name];
    }

    /**
     * creates class instance form encoded string.
     *
     * @return static
     */
    public static function decode(string $encoded)
    {
        $json = (new Base64URLDecode())($encoded);

        return new static((new JsonDecode(true))($json));
    }

    /**
     * create encoded string from the current instance.
     */
    public function encode(): string
    {
        return (new Base64URLEncode())((new JsonEncode())($this->attributes));
    }
}
