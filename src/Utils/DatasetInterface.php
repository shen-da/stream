<?php

declare(strict_types=1);

namespace Loner\Stream\Utils;

/**
 * 数据集
 */
interface DatasetInterface
{
    /**
     * 返回默认数据集
     *
     * @return array
     */
    public static function dataset(): array;

    /**
     * 批量修改数据
     *
     * @param array $options
     * @return void
     */
    public function set(array $options): void;
}
