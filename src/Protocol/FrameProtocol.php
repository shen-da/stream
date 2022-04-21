<?php

declare(strict_types=1);

namespace Loner\Stream\Protocol;

use Loner\Stream\{Exception\DecodedException, Message\FrameMessage};

/**
 * 简单帧协议
 */
class FrameProtocol implements ProtocolInterface
{
    /**
     * @inheritDoc
     */
    public function input(string $buffer): ?int
    {
        return strlen($buffer) >= 4 ? unpack('Nlength', $buffer)['Nlength'] : null;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $package): FrameMessage
    {
        if (strlen($package) >= 4) {
            return new FrameMessage(substr($package, 4));
        }
        throw new DecodedException();
    }
}
