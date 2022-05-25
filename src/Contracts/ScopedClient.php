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

interface ScopedClient
{
    /**
     * Returns the list of scopes defines on the array.
     *
     * @return string[]|array
     */
    public function getScopes();

    /**
     * @param Scope|string|string[] $scope
     *
     * @return bool
     */
    public function hasScope($scope);
}
