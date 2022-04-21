<?php

declare(strict_types=1);

namespace Loner\Stream\Server;

use Loner\Stream\Exception\ServerCreatedException;
use Loner\Stream\Utils\{Resources, WithProtocol};
use Loner\Stream\Event\{Start, Stop};
use Loner\Stream\Site\{EventDispatch, SocketAddress};

/**
 * 流服务端
 */
abstract class Server implements ServerInterface
{
    use Resources, WithProtocol;
    use EventDispatch, SocketAddress;

    /**
     * 资源流上下文
     *
     * @var resource
     */
    protected $context;

    /**
     * 返回监听网络标志组合
     *
     * @return int
     */
    abstract protected static function flags(): int;

    /**
     * 接收远程连接或信息
     *
     * @return void
     */
    abstract protected function accept(): void;

    /**
     * @inheritDoc
     */
    public function listen(): void
    {
        if ($this->socket === null) {
            $this->createSocket();
            $this->setReadListener($this->accept(...));
        }
    }

    /**
     * @inheritDoc
     */
    public function unListen(): void
    {
        if (isset($this->socket)) {
            $this->closeAll();
        }
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        $this->listen();
        $this->eventDispatch(Start::class, $this);
        $this->reactor->loop();
    }

    /**
     * @inheritDoc
     */
    public function stop(): void
    {
        $this->unListen();
        $this->eventDispatch(Stop::class, $this);
        $this->reactor->destroy();
    }

    /**
     * @inheritDoc
     */
    protected function dispatchClear(): void
    {
        $this->eventListeners = [];
    }

    /**
     * 确保移除网络监听
     */
    public function __destruct()
    {
        $this->unListen();
    }

    /**
     * 资源流上下文配置
     *
     * @param array $options
     * @return void
     */
    protected function contextualize(array $options): void
    {
        if (!isset($options['socket']['backlog'])) {
            $options['socket']['backlog'] = self::DEFAULT_BACKLOG;
        }

        $this->context = stream_context_create($options);
    }

    /**
     * 套接字设置
     *
     * @return void
     */
    protected function setSocket(): void
    {
        stream_set_blocking($this->socket, false);
    }

    /**
     * 创建主套接字
     *
     * @return void
     * @throws ServerCreatedException
     */
    private function createSocket(): void
    {
        $socket = stream_socket_server($this->getSocketAddress(), $errorCode, $errorMessage, static::flags(), $this->context);
        if (!$socket) {
            throw new ServerCreatedException(
                sprintf('Server[%s] create failed：%d %s', $this->getSocketAddress(), $errorCode ?? 0, $errorMessage ?? 'unknown')
            );
        }
        $this->socket = $socket;
        $this->setSocket();
    }
}
