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

use Drewlabs\Oauth\Clients\Argon2iHashClientSecret;
use Drewlabs\Oauth\Clients\Contracts\SecretClientInterface;
use Drewlabs\Oauth\Clients\PasswordVerifyClientSecretEngine;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Argon2iHashClientSecretTest extends TestCase
{
    public function test_argon2i_hash_client_secret_returns_string_hashed_value()
    {
        $secretHash = new Argon2iHashClientSecret();
        $is_string = \is_string($secretHash->hashSecret('MySuperSecretPassword'));
        $this->assertTrue($is_string);
    }

    public function test_verify_client_secret_returns_true_on_result_of_argon2i_hash_if_password_equals_original()
    {
        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new Argon2iHashClientSecret())->hashSecret('MyPassword'));

        // Assert
        $this->assertTrue((new PasswordVerifyClientSecretEngine())->verify($client, 'MyPassword'));
    }

    public function test_verify_client_secret_returns_false_on_result_of_argon2i_hash_if_password_does_not_equals_original()
    {
        /**
         * @var SecretClientInterface&MockObject
         */
        $client = $this->createMock(SecretClientInterface::class);

        $client->method('getHashedSecret')
            ->willReturn((new Argon2iHashClientSecret())->hashSecret('FakePassword'));

        // Assert
        $this->assertFalse((new PasswordVerifyClientSecretEngine())->verify($client, 'MyPassword'));
    }
}
