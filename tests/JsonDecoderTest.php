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

use Drewlabs\Oauth\Clients\JsonDecode;
use Drewlabs\Oauth\Clients\JsonEncode;
use PHPUnit\Framework\TestCase;

class JsonDecoderTest extends TestCase
{
    public function test_json_encode_invoke_create_a_json_string()
    {
        $jsonnable = ['name' => 'John Doe', 'iat' => time()];
        $json = (new JsonEncode())($jsonnable);
        $is_string = \is_string($json);
        $this->assertTrue($is_string);
        $this->assertNotSame($json, json_encode($jsonnable));
    }

    public function test_json_decode_return_associative_array()
    {
        $timestamp = time();
        $jsonnable = ['name' => 'John Doe', 'iat' => $timestamp];
        $json = (new JsonEncode())($jsonnable);

        $decoded = (new JsonDecode(true))($json);

        $this->assertSame($timestamp, $decoded['iat']);
        $this->assertSame('John Doe', $decoded['name']);

    }
}
