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

use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\HttpSelector;
use Drewlabs\AuthorizedClients\Tests\HttpClientStub;
use PHPUnit\Framework\TestCase;

class HttpSelectorTest extends TestCase
{
    private function createSelector()
    {
        return HttpSelector::using(new HttpClientStub())->withCredentials('<CLIENT_ID>', '<CLIENT_SECRET>');
    }

    public function test_invoke_return_instance_of_client()
    {
        $selector = $this->createSelector();
        $client = $selector->__invoke('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf');
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }

    public function test_invoke_return_null()
    {
        $selector = $this->createSelector();
        $client = $selector->__invoke('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1f');
        $this->assertNotInstanceOf(ClientInterface::class, $client);
        $this->assertNull($client);
    }
}
