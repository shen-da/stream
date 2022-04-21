<?php

declare(strict_types=1);

namespace Loner\Stream\Site;

/**
 * 监听地址
 */
trait SocketAddress
{
    /**
     * @inheritDoc
     */
    public function getSocketAddress(): string
    {
        return $this->address ??= static::transport() . '://' . $this->getTarget();
    }
}
