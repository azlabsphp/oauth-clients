# Authorized Clients

This library or package provides developpers with APIs for implementing server authorized clients.

It only offers the validation and an Http Selector implementation and leaves to the developper the option to implements his own custom client verification. It simply enforces the rules arround client verification implementation using interfaces definition.

By definition, client that access ressources on a given server have an identifier and a secret to used to validate them. The packahe extends the basic definition of a client by adding an additional layer of authorization using scopes.

- Scopes

scopes provides an additional layer of authorization to resources, that developpers can leverage to restrict access for a given client to a given resource action, or specific path.

Scopes can be in form of `resource:action` or  `module:resource:action`, or `resource`, depending of the application needs. There is not strict rule about how scopes must be labelled.

## Installation

As for many PHP libraries, we recommend using composer package manager to install the library. As the library is not officially published, composer configuration might require specifying a vcs repository type to load the library from. Therefore your composer.json file might looks like:

```json
"name": "vendor/project",
//....
"require": {
    "drewlabs/authorized-clients": "^0.1.0"
    // ... Other dependencies
},

// ...
"repositories": [
    {
        "type": "vcs",
        "url": ""
    }
]
```

## Usage

The package a part from being an interface definition provides a validation implementation that tends to be generic on how application selects clients to validate. This means that you are free to write your custom query selector that retrieve client from your favourite data source (database, file, http, etc...) and the validator will validate the client using your provided validation logic in the client class implementations.

Here is an example that uses an Http web service as data source provider to query and validates client:

```php
// HttpClient.php

// The class makes use of TheLeague Psr7 http client interface
use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ClientInterface
{

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $query = [];
        parse_str((string)$request->getUri()->getQuery(), $query);
        $attributes = array_values(array_filter(ClientsStub::getClients(), function($current) use ($query) {
            return $current['id'] === $query['client'] && $current['secret'] === $query['secret'];
        }));
        if (!empty($attributes)) {
            return new Response(200, [], json_encode($attributes[0]));
        }
        return new Response(404);
    }
}

// ValidateClient.php
use Drewlabs\AuthorizedClients\AuthorizedClientValidator;
use Drewlabs\AuthorizedClients\Contracts\ClientInterface;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;
use Drewlabs\AuthorizedClients\HttpSelector;
use Drewlabs\AuthorizedClients\Tests\HttpClientStub;

// Create the {@see AuthorizedClientValidator} instance
$validator = new AuthorizedClientValidator(new HttpSelector(new HttpClient));

// After the validator is created using the provided http client selector
// we call the validate method of the validator
// This will throw an {@see UnAuthorizedClientException} exception if validation fails
$client = $validator->validate('bdcf5a49-341e-4688-8bba-755237ecfaa1', '02afd968d07c308b6eda2fcf5915878a079f1bbf');

// Returns true if the validated client is first party client
$client->firstParty();

// Checks if the client is still active and has not be revoked
$client->isRevoked();
```
