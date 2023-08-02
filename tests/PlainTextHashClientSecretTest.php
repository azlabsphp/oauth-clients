<?php

use Drewlabs\Oauth\Clients\PlainTextHashClientSecret;
use Drewlabs\Oauth\Clients\VerifyPlainTextSecretEngine;
use PHPUnit\Framework\TestCase;
use Drewlabs\Oauth\Clients\Contracts\SecretClientInterface;
use PHPUnit\Framework\MockObject\MockObject;

class PlainTextHashClientSecretTest extends TestCase
{

    public function test_plain_text_hash_returns_same_string_passed_as_parameter_to_hash_secret()
    {
        $plainTextHash = new PlainTextHashClientSecret;
        $this->assertEquals('PlainTextPassword', $plainTextHash->hashSecret('PlainTextPassword'));
    }

    public function test_verify_plain_text_hash_returns_true_if_string_matches_original_string()
    {

        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new PlainTextHashClientSecret)->hashSecret('MyPassword'));

        // Assert
        $this->assertTrue((new VerifyPlainTextSecretEngine)->verify($client, 'MyPassword'));
    }

    public function test_verify_plain_text_hash_returns_false_if_string_does_not_matches_original_string()
    {
        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new PlainTextHashClientSecret)->hashSecret('FakePassword'));

        // Assert
        $this->assertFalse((new VerifyPlainTextSecretEngine)->verify($client, 'MyPassword'));
    }
}
