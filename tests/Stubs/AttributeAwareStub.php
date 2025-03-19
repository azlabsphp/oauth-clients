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

class AttributeAwareStub implements AttributesAware
{
    /**
     * @var array<string,mixed>
     */
    private $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
