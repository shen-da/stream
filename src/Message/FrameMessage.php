<?php

declare(strict_types=1);

namespace Loner\Stream\Message;

use Stringable;

/**
 * 基于简单帧协议的消息
 */
class FrameMessage implements Stringable
{
    /**
     * 初始化消息内容
     *
     * @param string $body
     */
    public function __construct(public readonly string $body)
    {
    }

    /**
     * 将消息转化为字符串数据包
     *
     * @return string
     */
    public function __toString(): string
    {
        return pack('N', 4 + strlen($this->body)) . $this->body;
    }
}
