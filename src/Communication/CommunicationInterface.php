<?php

declare(strict_types=1);

namespace Loner\Stream\Communication;

/**
 * 通信
 */
interface CommunicationInterface
{
    /**
     * 开始（或继续）监听接收数据
     *
     * @return void
     */
    public function resumeReceive(): void;

    /**
     * 停止（或暂停）监听接收数据
     *
     * @return void
     */
    public function pauseReceive(): void;
}
