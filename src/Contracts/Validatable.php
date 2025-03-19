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

use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;

/**
 * @internal
 *
 * @deprecated
 *
 * **Note** This interface is internal as it should not be implemented by outside classes
 *          as `validate(...)` method will be merged into `ClientInterface` contract.
 *          It's temporary extracted from `ClientInterface` to prevent any breaking change
 *          in existing implementation libraries
 */
interface Validatable
{
    /**
     * returns a boolean flag which equals true if client is matches the specified
     * scopes and allows request from the given ip address.
     *
     * @throws AuthorizationException
     */
    public function validate(array $scopes = [], ?string $ip = null): bool;
}
