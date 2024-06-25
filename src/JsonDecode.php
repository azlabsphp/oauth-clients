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

class JsonDecode
{
    /** @var bool*/
    private $associative = false;

    /** @var int */
    private $flags;

    /** @var int */
    private $depth;

    /**
     * creates class instance.
     *
     * @param bool $associative
     *
     * @return void
     */
    public function __construct($associative = false, int $flags = 0, int $depth = 512)
    {
        $this->flags = $flags;
        $this->depth = $depth;
        $this->associative = $associative;

    }

    /**
     * Decodes a json string
     *
     * @return mixed
     */
    public function __invoke(string $encoded)
    {
        return $this->call($encoded);
    }

    /**
     * return a decoded string data.
     *
     * @return mixed
     */
    public function call(string $encoded)
    {
        return json_decode($encoded, $this->associative, $this->depth, $this->flags);
    }
}
