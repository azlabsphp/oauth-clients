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

use Drewlabs\Oauth\Clients\ApiToken;
use PHPUnit\Framework\TestCase;

class ApiTokenTest extends TestCase
{
    public function test_api_token_get_secret()
    {
        $apiToken = new ApiToken('qPrNrw1Wi3vgRqZCX2p8t1hJp3KAInGM3M3VUNuey3DHBHqYbFAQqSnI8tMcXGoE');
        $this->assertSame('qPrNrw1Wi3vgRqZCX2p8t1hJp3KAInGM3M3VUNuey3DHBHqYbFAQqSnI8tMcXGoE', $apiToken->getSecret());
    }

    public function test_api_token_to_string()
    {
        $apiToken = new ApiToken('rVER6OpDDVqeMSJyGsKOMLCbqqtDn4z5');
        $this->assertSame('rVER6OpDDVqeMSJyGsKOMLCbqqtDn4z5', (string) $apiToken);
        $this->assertSame('rVER6OpDDVqeMSJyGsKOMLCbqqtDn4z5', $apiToken->__toString());
    }
}
