<?php

declare(strict_types=1);

namespace Loner\Stream\Protocol;

use Loner\Stream\{Exception\DecodedException, Message\TextMessage};

/**
 * 简单文本协议
 */
class TextProtocol implements ProtocolInterface
{
    /**
     * @inheritDoc
     */
    public function input(string $buffer): ?int
    {
        $pos = strpos($buffer, "\n");
        return $pos === false ? null : $pos + 1;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $package): TextMessage
    {
        if (str_ends_with($package, "\n")) {
            $length = str_ends_with($package, "\r\n") ? -2 : -1;
            $message = substr($package, 0, $length);
            return new TextMessage($message);
        }
        throw new DecodedException();
    }
}
