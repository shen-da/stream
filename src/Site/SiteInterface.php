<?php

declare(strict_types=1);

namespace Loner\Stream\Site;

/**
 * 端
 */
interface SiteInterface
{
    /**
     * 返回传输协议类型
     *
     * @return string
     */
    public static function transport(): string;

    /**
     * 返回监听地址
     *
     * @return string
     */
    public function getTarget(): string;

    /**
     * 返回监听完整地址
     *
     * @return string
     */
    public function getSocketAddress(): string;
}
