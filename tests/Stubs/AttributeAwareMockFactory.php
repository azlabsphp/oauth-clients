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

namespace Drewlabs\Oauth\Clients\Tests\Stubs;

use Drewlabs\Oauth\Clients\Contracts\AttributesAware;
use PHPUnit\Framework\MockObject\MockObject;

trait AttributeAwareMockFactory
{
    public function createAttributeAware(array $values = [])
    {
        $attributes = $values ?? [];
        /**
         * @var AttributesAware&MockObject
         */
        $instance = $this->createMock(AttributesAware::class);

        $instance->method('getAttribute')
            ->willReturnCallback(static function (string $property) use ($attributes) {
                return $attributes[$property] ?? null;
            });

        $instance->method('toArray')
            ->willReturn($attributes);

        return $instance;
    }
}
