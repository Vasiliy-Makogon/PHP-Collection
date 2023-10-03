<?php

declare(strict_types=1);

namespace Krugozor\Cover;

/**
 * @package Krugozor\Cover
 */
trait Simple
{
    /** @var array */
    protected array $data = [];

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $key
     */
    public function __unset(string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Возвращает элемент коллекции с заданным индексом в качестве результата.
     * Аналог __get, но предназначен для числовых индексов.
     *
     * @param int|string $key
     * @return mixed
     */
    public function item(int|string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param iterable|null $data
     * @return static
     */
    public function setData(?iterable $data): static
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * @return static
     */
    public function clear(): static
    {
        $this->data = [];

        return $this;
    }
}