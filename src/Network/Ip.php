<?php

declare(strict_types=1);

namespace Loner\Stream\Network;

/**
 * IP
 */
class Ip
{
    /**
     * 获取 IP
     *
     * @param string $address
     * @return string
     */
    public static function get(string $address): string
    {
        $position = strrpos($address, ':');
        return $position ? substr($address, 0, $position) : '';
    }

    /**
     * 是否 IpV4
     *
     * @param string $address
     * @return bool
     */
    public static function isV4(string $address): bool
    {
        return !str_contains(self::get($address), ':');
    }

    /**
     * 是否 IpV6
     *
     * @param string $address
     * @return bool
     */
    public static function isV6(string $address): bool
    {
        return str_contains(self::get($address), ':');
    }
}
