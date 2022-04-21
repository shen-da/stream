<?php

declare(strict_types=1);

namespace Loner\Stream\Exception;

use Exception;

/**
 * 解包异常（数据不符合应用层协议）
 */
class DecodedException extends Exception implements ExceptionInterface
{
}
