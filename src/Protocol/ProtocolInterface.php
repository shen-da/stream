<?php

declare(strict_types=1);

namespace Loner\Stream\Protocol;

use Loner\Stream\Exception\DecodedException;
use Stringable;

/**
 * 应用层协议
 */
interface ProtocolInterface
{
    /**
     * 读取从通信端接收到的数据，尝试解析出完整消息
     *
     * @param string $buffer
     * @return int|null
     */
    public function input(string $buffer): ?int;

    /**
     * 解码数据包，获取完整消息
     *
     * @param string $package
     * @return Stringable
     * @throws DecodedException
     */
    public function decode(string $package): Stringable;
}
