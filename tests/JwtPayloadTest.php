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

namespace Drewlabs\Oauth\Clients\Tests;

use Drewlabs\Oauth\Clients\JwtPayload;
use PHPUnit\Framework\TestCase;

class JwtPayloadTest extends TestCase
{
    public function test_jwt_payload_get_value()
    {
        $attributes = ['name' => 'John Doe', 'iat' => time()];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertSame($attributes, $jwtPayload->getValue());
    }

    public function test_jwt_payload_get_attribute_return_matching_attribute_value()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertSame('John Doe', $jwtPayload->getAttribute('name'));
        $this->assertSame($timestamp, $jwtPayload->getAttribute('iat'));
    }

    public function test_jwt_payload_get_attribute_return_null_case_no_match_found()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertNull($jwtPayload->getAttribute('sub'));
    }

    public function test_jwt_payload_endode()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);
        $is_string = is_string($jwtPayload->encode());
        $this->assertTrue($is_string);
    }

    public function test_jwt_payload_decode()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $encoded = $jwtPayload->encode();

        $jwtPayload2 = JwtPayload::decode($encoded);
        $this->assertSame('John Doe', $jwtPayload2->getAttribute('name'));
        $this->assertSame($timestamp, $jwtPayload2->getAttribute('iat'));
    }
}
