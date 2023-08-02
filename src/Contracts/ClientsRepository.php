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

interface ClientsRepository
{
    /**
     * Find a client instance using user id.
     *
     * @param mixed $identifier
     */
    public function findByUserId($identifier): ClientInterface;

    /**
     * Find a client instance using `id` property.
     *
     * @param string|int $id
     */
    public function findById($id): ClientInterface;

    /**
     * Update client instance using `id` property.
     *
     * @param string|int $id
     *
     * @return ClientInterface|mixed
     */
    public function updateById($id, NewClientInterface $attributes, \Closure $callback = null);

    /**
     * Creates a new client instance.
     *
     * @return ClientInterface&PlainTextSecretAware|mixed
     */
    public function create(NewClientInterface $attributes, \Closure $callback = null);

    /**
     * Delete client using `id` property.
     *
     * @param string|int $id
     *
     * @return bool
     */
    public function deleteById($id, \Closure $callback = null);
}
