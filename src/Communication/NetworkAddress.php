<?php

declare(strict_types=1);

namespace Loner\Stream\Communication;

/**
 * 网络地址
 */
trait NetworkAddress
{
    /**
     * 返回本地地址
     *
     * @return string
     */
    public function getLocalAddress(): string
    {
        return $this->localAddress ??= (string)stream_socket_get_name($this->socket, false);
    }

    /**
     * 返回远程地址
     *
     * @return string
     */
    public function getRemoteAddress(): string
    {
        return $this->remoteAddress ??= (string)stream_socket_get_name($this->socket, true);
    }
}
