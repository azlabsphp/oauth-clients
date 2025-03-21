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

/**
 * **Note** This contract is extracted from client repository contract to avoid
 *          any breaking change in existing code, but will be added to the `ClientsRepository`
 *          contract from version 0.4.x. Therefore any class implementing `ClientsRepository`
 *          contract should implements the class in future release to be compatible with future
 *          implementations of the current library.
 */
interface ApiKeyClientsRepository
{
    /**
     * Finds client instance by api_key property value.
     */
    public function findByApiKey(string $key): ?ClientInterface;
}
