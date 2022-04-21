<?php

declare(strict_types=1);

namespace Loner\Stream\Event;

use Loner\Stream\Client\Client;

/**
 * 流客户端事件：打开到流服务端的通信网络失败
 */
class OpenFail
{
    public function __construct(
        public readonly Client $client,
        public readonly string $message,
        public readonly int $code
    )
    {
    }
}
