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

namespace Drewlabs\Oauth\Clients\OAuth2;

use Drewlabs\Oauth\Clients\Contracts\ClientInterface;
use Drewlabs\Oauth\Clients\Contracts\RedirectUrlAware;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class Client implements ClientEntityInterface
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $redirect;

    /**
     * @var bool
     */
    private $confidential;

    public function __construct($id, $name, $redirect = null, bool $confidential = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->redirect = $redirect;
        $this->confidential;
    }

    /**
     * Create new client instance from an oauth client client instance.
     *
     * @param ClientInterface&RedirectUrlAware $client
     *
     * @return static
     */
    public static function fromOauthClient($client)
    {
        return new static($client->getKey(), $client->getName(), $client->getRedirectUrl(), $client->isConfidential());
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRedirectUri()
    {
        return $this->redirect;
    }

    public function isConfidential()
    {
        return $this->confidential;
    }
}
