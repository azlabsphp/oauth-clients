<?php

use Drewlabs\Oauth\Clients\JwtPayload;
use PHPUnit\Framework\TestCase;

class JwtPayloadTest extends TestCase
{
    public function test_jwt_payload_get_value()
    {
        $attributes = ['name' => 'John Doe', 'iat' => time()];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertEquals($attributes, $jwtPayload->getValue());
    }

    public function test_jwt_payload_get_attribute_return_matching_attribute_value()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertEquals('John Doe', $jwtPayload->getAttribute('name'));
        $this->assertEquals($timestamp, $jwtPayload->getAttribute('iat'));

    }

    public function test_jwt_payload_get_attribute_return_null_case_no_match_found()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertEquals(null, $jwtPayload->getAttribute('sub'));

    }

    public function test_jwt_payload_endode()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $this->assertTrue(is_string($jwtPayload->encode()));

    }

    public function test_jwt_payload_decode()
    {
        $timestamp = time();
        $attributes = ['name' => 'John Doe', 'iat' => $timestamp];
        $jwtPayload = new JwtPayload($attributes);

        $encoded  = $jwtPayload->encode();

        $jwtPayload2 = JwtPayload::decode($encoded);
        $this->assertEquals('John Doe', $jwtPayload2->getAttribute('name'));
        $this->assertEquals($timestamp, $jwtPayload2->getAttribute('iat'));

    }
}