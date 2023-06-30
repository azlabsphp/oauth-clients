<?php

use Drewlabs\AuthorizedClients\JwtHeader;
use PHPUnit\Framework\TestCase;

class JwtHeaderTest extends TestCase
{

    public function test_jwt_header_get_alg_and_get_typ()
    {
        $jwtHeader = new JwtHeader();

        $this->assertEquals('HS256', $jwtHeader->getAlg());
        $this->assertEquals('JWT', $jwtHeader->getTyp());
    }

    public function test_jwt_header_encode()
    {
        $jwtHeader = new JwtHeader;

        $encoded = $jwtHeader->encode();

        $this->assertTrue(is_string($encoded));
    }

    public function test_jwt_header_decode()
    {

        $jwtHeader = new JwtHeader;

        $encoded = $jwtHeader->encode();

        $jwtHeader2 = JwtHeader::decode($encoded);

        $this->assertEquals('HS256', $jwtHeader->getAlg());
        $this->assertEquals('JWT', $jwtHeader->getTyp());
    }
}