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

class JsonEncode
{
    /**
     * @var int
     */
    private $flags;

    /**
     * @var int
     */
    private $depth;

    /**
     * creates class instance
     * 
     * @param int $flags 
     * @param int $depth 
     */
    public function __construct(int $flags = 0, int $depth = 512)
    {
        $this->flags = $flags;
        $this->depth = $depth;
    }

    /**
     * return a json encoded string
     * 
     * @param string|array|object $value 
     * @return string 
     * @throws InvalidArgumentException 
     */
    public function call($value)
    {
        return json_encode(static::recursiveksort($value), $this->flags, $this->depth);
    }

    /**
     * functional interface for json encoding data
     * 
     * @param mixed $data 
     * @return string 
     * @throws InvalidArgumentException 
     */
    public function __invoke($data)
    {
        return $this->call($data);
    }

    /**
     * @param callable|\Closure $sort
     *
     * @return array
     */
    private static function recursiveKSort(array $value, $sort = null)
    {
        $sort = $sort ?? 'ksort';

        // region Internal sort function
        $callable = static function (array &$list) use ($sort, &$callable) {
            foreach ($list as $key => $value) {
                $is_object = \is_object($value);
                if ($is_object || \is_array($value)) {
                    $current = $is_object ? get_object_vars($value) : $value;
                    $callable($current);
                    $list[$key] = $current;
                }
            }
            \call_user_func_array($sort, [&$list]);
        };
        $callable($value);
        // endregion Internal function
        return $value;
    }
}
