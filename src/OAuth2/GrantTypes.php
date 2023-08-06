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

class GrantTypes
{
    /**
     * @const string
     */
    public const AUTHORIZATION_CODE_GRANT = 'authorization_code';

    /**
     * @const string
     */
    public const PERSONAL_ACCESS_GRANT = 'personal_access';

    /**
     * @const string
     */
    public const PASSWORD_GRANT = 'password';

    /**
     * @const string
     */
    public const CLIENT_CREDENTIALS_GRANT = 'client_credentials';
}
