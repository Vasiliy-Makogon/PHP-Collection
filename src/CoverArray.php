<?php

declare(strict_types=1);

namespace Krugozor\Cover;

/**
 * Объектный массив.
 * @package Krugozor\Cover
 */
class CoverArray implements \IteratorAggregate, \Countable, \ArrayAccess
{
    use Simple;

    /**
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $this->setData($data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $this->array2cover($value);
    }

    /**
     * Реализация интерфейса Countable
     *
     * @return int
     */
    final public function count(): int
    {
        return count($this->data);
    }

    /**
     * Реализация интерфейса IteratorAggregate
     *
     * @return \ArrayIterator
     */
    final public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * Присоединяет один элемент в начало массива.
     *
     * @param mixed ...$args
     * @return static
     */
    final public function prepend(mixed ...$args): static
    {
        foreach ($args as $value) {
            array_unshift($this->data, $this->array2cover($value));
        }

        return $this;
    }

    /**
     * Присоединяет один или более элементов в конец массива.
     *
     * @param mixed ...$args
     * @return static
     */
    final public function append(mixed ...$args): static
    {
        foreach ($args as $value) {
            array_push($this->data, $this->array2cover($value));
        }

        return $this;
    }

    /**
     * Возвращает последний элемент массива.
     *
     * @return mixed
     */
    final public function getLast(): mixed
    {
        $last = end($this->data);
        reset($this->data);

        return $last;
    }

    /**
     * Возвращает первый элемент массива.
     *
     * @return mixed
     */
    final public function getFirst(): mixed
    {
        reset($this->data);
        $first = current($this->data);
        reset($this->data);

        return $first;
    }

    /**
     * Возвращает данные объекта как массив.
     *
     * @return array
     */
    final public function getDataAsArray(): array
    {
        $data = [];

        foreach ($this->getData() as $key => $value) {
            $data[$key] = is_object($value) && $value instanceof static
                ? $value->{__FUNCTION__}()
                : $value;
        }

        return $data;
    }

    /**
     * Реализация метода интерфейса ArrayAccess::offsetSet.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    final public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $this->array2cover($value);
        } else {
            $this->data[$offset] = $this->array2cover($value);
        }
    }

    /**
     * Реализация метода интерфейса ArrayAccess::offsetExists.
     *
     * @param mixed $offset
     * @return bool
     */
    final public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * Реализация метода интерфейса ArrayAccess::offsetUnset.
     *
     * @param mixed $offset
     */
    final public function offsetUnset(mixed $offset): void
    {
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Реализация метода интерфейса ArrayAccess::offsetGet.
     *
     * @param mixed $offset
     * @return mixed
     */
    final public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function __unserialize(array $data): void
    {
        $this->setData($data);
    }

    /**
     * @return array
     * @see array_reverse
     */
    final public function reverse(): array
    {
        return array_reverse($this->data);
    }

    /**
     * Возвращает данные по ключам многомерных массивов через dot-нотацию.
     * Пример:
     *    $cover->get('prop.prop2.prop3');
     *    $cover->get('prop.prop2.0');
     *
     * @param string $path
     * @return mixed
     */
    final public function get(string $path): mixed
    {
        if ($path === '') {
            return null;
        }

        list(0 => $key, 1 => $other) = array_pad(explode('.', $path, 2), 2, null);

        $actual_data = $this->data[$key] ?? null;

        // Закончились ключи в цепочке следования
        if ($other === null) {
            return $actual_data;
        }

        // Попытка вызывать ключ на значении
        if (!is_object($actual_data) || !$actual_data instanceof static) {
            return null;
        }

        return $this->data[$key]->get($other);
    }

    /**
     * @param callable|null $callback
     * @param int $mode
     * @return static
     * @see array_filter
     */
    final public function filter(?callable $callback = null, int $mode = 0): static
    {
        return new static(array_filter($this->data, $callback, $mode));
    }

    /**
     * @param string $separator
     * @return string
     */
    final public function implode(string $separator): string
    {
        return implode($separator, $this->data);
    }

    /**
     * Применяет callback-функцию ко всем элементам ассоциативного массива.
     * Пример callback: fn(string $key, string $value): string => "$key: $value"
     *
     * @param callable $callback
     * @return static
     * @see array_map
     */
    final public function mapAssociative(callable $callback): static
    {
        return new static(array_map($callback, array_keys($this->data), array_values($this->data)));
    }

    /**
     * Применяет callback-функцию ко всем элементам массива.
     * Пример callback: fn(string $value): string => "value: $value"
     *
     * @param callable $callback
     * @return static
     */
    final public function map(callable $callback): static
    {
        return new static(array_map($callback, $this->data));
    }

    /**
     * Возвращает объект текущего типа, если переданным в метод значением является массив.
     * Вложенные элементы массива так же становятся объектом текущего типа.
     *
     * @param mixed $value
     * @return mixed
     */
    final protected function array2cover(mixed $value): mixed
    {
        return is_array($value) ? new static($value) : $value;
    }
}