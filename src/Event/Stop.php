<?php

declare(strict_types=1);

namespace Loner\Stream\Event;

use Loner\Stream\Server\Server;

/**
 * 流服务端事件：服务器停止（移除监听网络后、破坏事件循环前）
 */
class Stop
{
    public function __construct(public readonly Server $server)
    {
    }
}
