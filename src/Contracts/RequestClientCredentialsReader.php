<?php

namespace Drewlabs\AuthorizedClients\Contracts;

use Psr\Http\Message\ServerRequestInterface;
use Drewlabs\AuthorizedClients\Exceptions\UnAuthorizedClientException;

interface RequestClientCredentialsReader
{
    /**
     * Returns a (client, secret) tuple from provided request.
     *
     * @throws UnAuthorizedClientException
     *
     * @return array
     */
    public function read(ServerRequestInterface $request);
}