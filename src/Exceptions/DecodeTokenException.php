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

namespace Drewlabs\AuthorizedClients\Exceptions;

class DecodeTokenException extends AuthorizationException
{
    /**
     * Creates class instance.
     */
    public function __construct(string $token, string $message = null)
    {
        $message = $message ?? sprintf('Error while decoding %s, unsupported format', $token);

        parent::__construct($message);
    }
}
