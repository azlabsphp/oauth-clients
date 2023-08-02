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

use Drewlabs\Oauth\Clients\BasicAuthCredentials;
use PHPUnit\Framework\TestCase;

class BasicAuthCredentialsTest extends TestCase
{
    public function test_basic_auth_credential_get_id()
    {
        $credentials = new BasicAuthCredentials('apiKey', 'rrssGv2ON3woCDcLGaChYLTtKcPq4Meu');
        $this->assertSame('apiKey', $credentials->getId());

    }

    public function test_basic_auth_credentials_get_secret()
    {
        $credentials = new BasicAuthCredentials('apiKey', '6aqidVCrVbQXEVLCScnwYC4xHm01J0XA');
        $this->assertSame('6aqidVCrVbQXEVLCScnwYC4xHm01J0XA', $credentials->getSecret());
    }

    public function test_basic_auth_credentials_to_string()
    {
        $credentials = new BasicAuthCredentials('apiKey', '6aqidVCrVbQXEVLCScnwYC4xHm01J0XA');
        $this->assertSame(base64_encode(sprintf('%s:%s', 'apiKey', '6aqidVCrVbQXEVLCScnwYC4xHm01J0XA')), $credentials->__toString());
        $this->assertSame(base64_encode(sprintf('%s:%s', 'apiKey', '6aqidVCrVbQXEVLCScnwYC4xHm01J0XA')), (string) $credentials);

    }

    public function test_basic_auth_credentials_static_new()
    {
        $result = base64_encode(sprintf('%s:%s', 'apiKey', 'NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0'));
        $basicAuth = BasicAuthCredentials::new($result);
        $this->assertSame('NXI4ZVg3Ps5eXzhC6YAR6l0N9DCClHY0', $basicAuth->getSecret());
        $this->assertSame('apiKey', $basicAuth->getId());

    }
}
