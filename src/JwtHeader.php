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

namespace Drewlabs\AuthorizedClients;

class JwtHeader
{
    /**
     * @var string
     */
    private $alg;

    /**
     * @var string
     */
    private $typ;

    /**
     * creates class instance
     * 
     * @param string $alg 
     * @param string $typ 
     */
    public function __construct($alg = 'HS256', $typ = 'JWT')
    {
        $this->alg = $alg;
        $this->typ = $typ;
    }

    /**
     * return `alg` header value
     * 
     * @return string 
     */
    public function getAlg()
    {
        return $this->alg;
    }

    /**
     * return header `typ` value
     * @return string 
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * creates class instance form encoded string
     * @param string $encoded 
     * @return static 
     */
    public static function decode(string $encoded)
    {
        $json = (new Base64URLDecode)($encoded);
        $object = (new JsonDecode)($json);
        return new static($object->alg, $object->typ);
    }

    /**
     * create encoded string from the current instance
     * 
     * @return string 
     */
    public function encode(): string
    {
        return (new Base64URLEncode)((new JsonEncode)(['alg' => $this->alg, 'typ' => $this->typ]));
    }

    /**
     * returns the encoded string of the current class
     * 
     * @return string 
     */
    public function __toString()
    {
        return $this->encode();
    }

}