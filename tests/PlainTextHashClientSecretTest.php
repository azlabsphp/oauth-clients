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

use Drewlabs\Oauth\Clients\Contracts\SecretClientInterface;
use Drewlabs\Oauth\Clients\PlainTextHashClientSecret;
use Drewlabs\Oauth\Clients\VerifyPlainTextSecretEngine;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PlainTextHashClientSecretTest extends TestCase
{
    public function test_plain_text_hash_returns_same_string_passed_as_parameter_to_hash_secret()
    {
        $plainTextHash = new PlainTextHashClientSecret();
        $this->assertSame('PlainTextPassword', $plainTextHash->hashSecret('PlainTextPassword'));
    }

    public function test_verify_plain_text_hash_returns_true_if_string_matches_original_string()
    {

        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new PlainTextHashClientSecret())->hashSecret('MyPassword'));

        // Assert
        $this->assertTrue((new VerifyPlainTextSecretEngine())->verify($client, 'MyPassword'));
    }

    public function test_verify_plain_text_hash_returns_false_if_string_does_not_matches_original_string()
    {
        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new PlainTextHashClientSecret())->hashSecret('FakePassword'));

        // Assert
        $this->assertFalse((new VerifyPlainTextSecretEngine())->verify($client, 'MyPassword'));
    }
}
