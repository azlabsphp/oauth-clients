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

namespace Drewlabs\AuthorizedClients\Contracts;

/**
 * Type definition for complex scope implementation.
 */
interface ScopeInterface
{
    /**
     * Returns the string representation of the scope object.
     */
    public function __toString(): string;
}
