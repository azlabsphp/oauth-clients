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

use Drewlabs\Oauth\Clients\JwtHeader;
use PHPUnit\Framework\TestCase;

class JwtHeaderTest extends TestCase
{
    public function test_jwt_header_get_alg_and_get_typ()
    {
        $jwtHeader = new JwtHeader();

        $this->assertSame('HS256', $jwtHeader->getAlg());
        $this->assertSame('JWT', $jwtHeader->getTyp());
    }

    public function test_jwt_header_encode()
    {
        $jwtHeader = new JwtHeader();

        $encoded = $jwtHeader->encode();
        $is_string = is_string($encoded);
        $this->assertTrue($is_string);
    }

    public function test_jwt_header_decode()
    {

        $jwtHeader = new JwtHeader();

        $encoded = $jwtHeader->encode();

        $jwtHeader2 = JwtHeader::decode($encoded);

        $this->assertSame('HS256', $jwtHeader->getAlg());
        $this->assertSame('JWT', $jwtHeader->getTyp());
    }
}
