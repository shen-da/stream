<?php

declare(strict_types=1);

namespace Loner\Stream\Server;

use Loner\Stream\{Exception\ServerCreatedException, Site\SiteInterface, Utils\WithProtocolInterface};

/**
 * 流服务端
 */
interface ServerInterface extends SiteInterface, WithProtocolInterface
{
    /**
     * 默认挂起连接数量上限
     */
    public const DEFAULT_BACKLOG = 102400;

    /**
     * 开启监听网络
     *
     * @return void
     * @throws ServerCreatedException
     */
    public function listen(): void;

    /**
     * 移除网络监听
     *
     * @return void
     */
    public function unListen(): void;

    /**
     * 启动流服务器
     *
     * @return void
     * @throws ServerCreatedException
     */
    public function start(): void;

    /**
     * 停止流服务器
     *
     * @return void
     */
    public function stop(): void;
}
