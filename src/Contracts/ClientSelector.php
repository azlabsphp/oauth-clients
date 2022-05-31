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
 * This interface defines a functional interface for getting.
 */
interface ClientSelector
{
    /**
     * Select the authorized client matching the credentials
     *
     * @param string|int $client
     * @param string     $secret
     *
     * @return ClientInterface|null
     */
    public function __invoke($client, $secret);
}
