<?php

declare(strict_types=1);

namespace Loner\Stream\Site;

/**
 * 事件调度
 */
trait EventDispatch
{
    /**
     * 事件监听器
     *
     * @var array<?callable>
     */
    protected array $eventListeners = [];

    /**
     * 事件分发
     *
     * @param string $event
     * @param mixed ...$arguments
     * @return void
     */
    protected function eventDispatch(string $event, mixed ...$arguments): void
    {
        if (isset($this->eventListeners[$event])) {
            $this->eventListeners[$event](new $event(...$arguments));
        }
    }
}
