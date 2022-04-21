<?php

declare(strict_types=1);

namespace Loner\Stream\Site;

/**
 * 网络的
 */
trait Networked
{
    /**
     * @inheritDoc
     */
    public function getTarget(): string
    {
        return $this->host . ':' . $this->port;
    }

    /**
     * 返回主机地址
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * 返回端口号
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}
