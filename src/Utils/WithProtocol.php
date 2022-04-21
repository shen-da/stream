<?php

declare(strict_types=1);

namespace Loner\Stream\Utils;

use Loner\Stream\Protocol\ProtocolInterface;

/**
 * 应用层协议
 */
trait WithProtocol
{
    /**
     * 应用层协议
     *
     * @var ProtocolInterface|null
     */
    protected ?ProtocolInterface $protocol = null;

    /**
     * @inheritDoc
     */
    public function setProtocol(ProtocolInterface $protocol): void
    {
        $this->protocol = $protocol;
    }

    /**
     * @inheritDoc
     */
    public function getProtocol(): ?ProtocolInterface
    {
        return $this->protocol;
    }
}
