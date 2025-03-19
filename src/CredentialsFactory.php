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

use Drewlabs\Oauth\Clients\Contracts\CredentialsFactoryInterface;
use Drewlabs\Oauth\Clients\Contracts\CredentialsIdentityInterface;
use Drewlabs\Oauth\Clients\Exceptions\AuthorizationException;

class CredentialsFactory implements CredentialsFactoryInterface
{
    /** @var CredentialsFactoryInterface[] */
    private $factories = [];

    /**
     * Create middleware class instance.
     *
     * @param CredentialsFactoryInterface[] ...$factories
     */
    public function __construct(...$factories)
    {
        $this->factories = $factories;
    }

    /**
     * Create a callable that resolve client credentials from request instance.
     *
     * @param mixed $request
     */
    public function create($request): ?CredentialsIdentityInterface
    {
        $factories = array_filter($this->factories ?? [], static function ($factory) {
            return null !== $factory;
        });
        $callbacks = array_map(static function (CredentialsFactoryInterface $factory) use ($request) {
            return static function ($credentials = null) use (&$factory, $request) {
                if (null === $credentials) {
                    return $factory->create($request);
                }

                return $credentials;
            };
        }, $factories);

        $credentials = $this->compose($callbacks)(null);

        if (null === $credentials) {
            throw new AuthorizationException('authorization key was not found');
        }

        return $credentials;
    }

    /**
     * Creates a pipeline of function through which the request is processed
     * to create a client credentials instance.
     *
     * @param callable[] $callbacks
     *
     * @return \Closure(mixed $source): mixed
     */
    private function compose(array $callbacks)
    {
        return static function ($source) use ($callbacks) {
            return array_reduce(
                $callbacks,
                static function ($carry, $func) {
                    return $func($carry);
                },
                $source
            );
        };
    }
}
