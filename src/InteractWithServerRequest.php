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

namespace Drewlabs\Oauth\Clients;

use Psr\Http\Message\ServerRequestInterface;

trait InteractWithServerRequest
{
    /**
     * Parse token from the authorization header.
     *
     * @param ServerRequestInterface $request
     * @param string                 $header
     * @param string                 $method
     *
     * @return ?string
     */
    private function getHeader($request, $header = 'authorization', $method = 'bearer')
    {
        $header = $request->getHeader($header);
        if (null === $header) {
            return null;
        }
        $header = array_pop($header);
        if (null === $header) {
            return null;
        }
        if (!$this->startsWith(strtolower($header), $method)) {
            return null;
        }

        return trim(str_ireplace($method, '', $header));
    }

    /**
     * checks if `$haystack` string starts with `$needle`.
     *
     * @return bool
     */
    private function startsWith(string $haystack, string $needle)
    {
        if (version_compare(\PHP_VERSION, '8.0.0') >= 0) {
            return str_starts_with($haystack, $needle);
        }

        return ('' === $needle) || (mb_substr($haystack, 0, mb_strlen($needle)) === $needle);
    }
}
