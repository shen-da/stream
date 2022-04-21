<?php

declare(strict_types=1);

namespace Loner\Stream\Event;

use Loner\Stream\Server\Server;

/**
 * 流服务端事件：服务器启动（创建监听网络后、进入事件循环前）
 */
class Start
{
    public function __construct(public readonly Server $server)
    {
    }
}
