<?php

declare(strict_types=1);

namespace Loner\Stream\Client;

use Loner\Stream\{Communication\CommunicationInterface, Site\SiteInterface, Utils\WithProtocolInterface};

/**
 * 流客户端
 */
interface ClientInterface extends CommunicationInterface, SiteInterface, WithProtocolInterface
{
    /**
     * 监听网络（内部确保网络创建）
     *
     * @return void
     */
    public function listen(): void;
}
