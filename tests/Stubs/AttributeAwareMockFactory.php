<?php


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
            ->willReturnCallback(function (string $property) use ($attributes) {
                return $attributes[$property] ?? null;
            });

        $instance->method('toArray')
            ->willReturn($attributes);

        return $instance;
    }
}
