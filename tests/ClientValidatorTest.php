<?php

use Drewlabs\AuthorizedClients\AuthorizedClientValidator;
use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\HttpSelector;
use Drewlabs\AuthorizedClients\Tests\HttpClientStub;
use PHPUnit\Framework\TestCase;

class ClientValidatorTest extends TestCase
{

    public function test_validate_returns_instance_of_client_interface()
    {
        $validator = new AuthorizedClientValidator(new HttpSelector(new HttpClientStub));
        $client = $validator->validate('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf');
        $this->assertInstanceOf(ClientInterface::class, $client);
        $this->assertTrue($client->firstParty());
        $this->assertFalse($client->isRevoked());
    }

    public function test_validate_throws_exception_for_missing_client_id_or_secret()
    {
        $this->expectException(UnAuthorizedClientException::class);
        $validator = new AuthorizedClientValidator(new HttpSelector(new HttpClientStub));
        $validator->validate('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1f');

    }

    public function test_validate_throws_exception_for_missing_scopes()
    {
        $this->expectException(UnAuthorizedClientException::class);
        $validator = new AuthorizedClientValidator(new HttpSelector(new HttpClientStub));
        $validator->validate('e28df7be-e9f7-4bd4-a689-c8a8d51afe96', '35a56ee81ae61f7464d4bffae812eafea2534c63', ['sys:all']);
    }

}