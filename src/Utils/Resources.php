<?php

declare(strict_types=1);

namespace Loner\Stream\Utils;

/**
 * 资源（事件循环、事件调度、监听网络、数据集）
 */
trait Resources
{
    /**
     * 主套接字
     *
     * @var resource|null
     */
    protected $socket = null;

    /**
     * 移除事件分发资源
     *
     * @return void
     */
    abstract protected function dispatchClear(): void;

    /**
     * 释放全部资源
     *
     * @return void
     */
    protected function closeAll(): void
    {
        $this->reactClear();
        $this->closeSocket();
        $this->dispatchClear();
    }

    /**
     * 返回套接字是否无效
     *
     * @return bool
     */
    protected function socketInvalid(): bool
    {
        return !is_resource($this->socket) || feof($this->socket);
    }

    /**
     * 关闭套接字流资源
     *
     * @return void
     */
    protected function closeSocket(): void
    {
        fclose($this->socket);
        $this->socket = null;
    }

    /**
     * 移除事件监听
     *
     * @return void
     */
    protected function reactClear(): void
    {
        $this->delReadListener();
    }

    /**
     * 设置读监听器
     *
     * @param callable $listener
     * @return bool
     */
    protected function setReadListener(callable $listener): bool
    {
        return $this->reactor->setRead($this->socket, $listener);
    }

    /**
     * 移除读监听器
     *
     * @return bool
     */
    protected function delReadListener(): bool
    {
        return $this->reactor->delRead($this->socket);
    }
}
