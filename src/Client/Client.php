<?php

declare(strict_types=1);

namespace Loner\Stream\Client;

use Loner\Stream\{Communication\Receive, Event\OpenFail};
use Loner\Stream\Site\{EventDispatch, SocketAddress};
use Loner\Stream\Utils\{Resources, WithProtocol};

/**
 * 流客户端
 */
abstract class Client implements ClientInterface
{
    use Receive, EventDispatch, SocketAddress, Resources, WithProtocol;

    /**
     * 绑定上下文
     *
     * @var resource|null
     */
    protected $context = null;

    /**
     * 返回监听网络标志组合
     *
     * @return int
     */
    abstract protected static function flags(): int;

    /**
     * 监听网络
     *
     * @return void
     */
    abstract protected function listening(): void;

    /**
     * @inheritDoc
     */
    public function listen(): void
    {
        if ($this->socket === null && $this->openCommunication()) {
            $this->listening();
        }
    }

    /**
     * @inheritDoc
     */
    protected function reactClear(): void
    {
        $this->delReadListener();
        $this->delWriteListener();
    }

    /**
     * 打开到流服务端的通信网络（套接字）
     *
     * @return bool
     */
    protected function openCommunication(): bool
    {
        $socket = stream_socket_client($this->getSocketAddress(), $errorCode, $errorMessage, null, static::flags(), $this->context);
        if ($socket === false) {
            $this->eventDispatch(OpenFail::class, $this, $errorMessage, $errorCode);
            return false;
        }
        $this->socket = $socket;
        return true;
    }
}
