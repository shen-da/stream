<?php

declare(strict_types=1);

namespace Loner\Stream\Communication;

/**
 * 接收
 */
trait Receive
{
    /**
     * 是否处于接收数据中
     *
     * @var bool
     */
    protected bool $receiving = false;

    /**
     * @inheritDoc
     */
    public function pauseReceive(): void
    {
        if ($this->receiving) {
            $this->receiving = false;
            $this->delReadListener();
        }
    }

    /**
     * 设置写监听器
     *
     * @param callable $listener
     * @return bool
     */
    protected function setWriteListener(callable $listener): bool
    {
        return $this->reactor->setWrite($this->socket, $listener);
    }

    /**
     * 移除写监听器
     *
     * @return bool
     */
    protected function delWriteListener(): bool
    {
        return $this->reactor->delWrite($this->socket);
    }

    /**
     * 释放资源
     */
    public function __destruct()
    {
        isset($this->socket) && $this->close();
    }
}
