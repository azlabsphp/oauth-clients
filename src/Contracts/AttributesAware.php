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

interface AttributesAware
{
    /**
     * Returns the value of `$name` attribute or property.
     *
     * @return mixed
     */
    public function getAttribute(string $name);

    /**
     * Returns array representation of the current instance.
     *
     * @return array
     */
    public function toArray();
}
