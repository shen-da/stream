<?php

declare(strict_types=1);

namespace Loner\Stream\Server;

use Loner\Reactor\ReactorInterface;
use Loner\Stream\{Network\Port, Site\Networked as SiteNetworked};

/**
 * 网络的
 */
trait Networked
{
    use SiteNetworked;

    /**
     * 初始化信息
     *
     * @param ReactorInterface $reactor
     * @param string $host
     * @param int $port
     * @param array $contextOptions
     * @param bool|null $reusable
     */
    public function __construct(
        public         readonly ReactorInterface $reactor,
        private string $host,
        private int    $port,
        array          $contextOptions = [],
        private ?bool  $reusable = null
    )
    {
        $this->contextualize($contextOptions);
    }

    /**
     * 返回是否端口复用
     *
     * @return bool
     */
    public function reusable(): bool
    {
        return $this->reusable ??= Port::reusable();
    }

    /**
     * 端口复用
     *
     * @return void
     */
    public function reusePort(): void
    {
        stream_context_set_option($this->context, 'socket', 'so_reuseport', 1);
    }
}
