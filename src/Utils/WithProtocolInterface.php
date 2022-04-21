<?php

declare(strict_types=1);

namespace Loner\Stream\Utils;

use Loner\Stream\Protocol\ProtocolInterface;

/**
 * 应用层协议相关
 */
interface WithProtocolInterface
{
    /**
     * 设置应用协议
     *
     * @param ProtocolInterface $protocol
     * @return void
     */
    public function setProtocol(ProtocolInterface $protocol): void;

    /**
     * 返回应用协议
     *
     * @return ProtocolInterface|null
     */
    public function getProtocol(): ?ProtocolInterface;
}
