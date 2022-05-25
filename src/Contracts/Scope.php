<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * Type definition for complex scope implementation.
 */
interface Scope
{
    /**
     * Returns the string representation of the scope object.
     *
     * @return string
     */
    public function __toString();
}
