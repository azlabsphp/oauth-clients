<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\AuthorizedClients\Tests;

class ClientsStub
{
    public static function getClients()
    {
        return [
            [
                'id' => 'bdcf5a49-341e-4688-8bba-755237ecfaa1',
                'name' => 'Contrary',
                'ip_addresses' => ['http://localhost:5000', 'http://localhost:5500'],
                'secret' => '02afd968d07c308b6eda2fcf5915878a079f1bbf',
                'redirect' => null,
                'provider' => 'local',
                'client_url' => 'http://localhost:5000',
                'expires_on' => null,
                'personal_access_client' => true,
                'password_client' => false,
                'scopes' => ['*'],
                'revoked' => false,
            ],
            [
                'id' => 'e28df7be-e9f7-4bd4-a689-c8a8d51afe96',
                'name' => 'Johnson M',
                'ip_addresses' => ['*'],
                'secret' => '35a56ee81ae61f7464d4bffae812eafea2534c63',
                'redirect' => null,
                'provider' => 'local',
                'expires_on' => null,
                'personal_access_client' => false,
                'password_client' => false,
                'scopes' => ['strage:object:write', 'strage:object:read'],
                'revoked' => false,
            ],
            [
                'id' => '1470d157-8378-4736-8e5f-443320b79832',
                'name' => 'Marial. M',
                'ip_addresses' => ['*'],
                'secret' => 'c46671c05790eb11fcb53f65fb7fa712639165cb',
                'redirect' => null,
                'provider' => 'local',
                'expires_on' => null,
                'personal_access_client' => false,
                'password_client' => false,
                'scopes' => null,
                'revoked' => true,
            ],
        ];
    }
}
