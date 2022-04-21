<?php

declare(strict_types=1);

namespace Loner\Stream\Client;

use Loner\{Reactor\ReactorInterface, Stream\Communication\NetworkAddress, Stream\Site\Networked as SiteNetworked};

/**
 * 网络的
 */
trait Networked
{
    use NetworkAddress, SiteNetworked;

    /**
     * 初始化信息
     *
     * @param ReactorInterface $reactor
     * @param string $host
     * @param int $port
     * @param array $contextOptions
     */
    public function __construct(public readonly ReactorInterface $reactor, private string $host, private int $port, array $contextOptions = [])
    {
        $this->context = $contextOptions ? stream_context_create($contextOptions) : null;
    }
}
