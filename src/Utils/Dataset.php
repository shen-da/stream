<?php

declare(strict_types=1);

namespace Loner\Stream\Utils;

/**
 * 数据集
 */
trait Dataset
{
    /**
     * 安全数据集
     *
     * @var array
     */
    private array $safeDataset;

    /**
     * 开放数据集
     *
     * @var array
     */
    private array $openDataset = [];

    /**
     * @inheritDoc
     */
    public function set(array $options): void
    {
        foreach ($options as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * 获取数据
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->getSafeDataset()[$name] ?? $this->openDataset[$name] ?? null;
    }

    /**
     * 修改数据
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $safeDataset = $this->getSafeDataset();
        if (isset($safeDataset[$name])) {
            if (gettype($safeDataset[$name]) === gettype($value)) {
                $this->safeDataset[$name] = $value;
            }
        } else {
            $this->openDataset[$name] = $value;
        }
    }

    /**
     * 初始化安全数据集
     *
     * @return array
     */
    private function getSafeDataset(): array
    {
        return $this->safeDataset ??= static::dataset();
    }
}
