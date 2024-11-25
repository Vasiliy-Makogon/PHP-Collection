<?php

declare(strict_types=1);

namespace Krugozor\Cover;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use ValueError;

/**
 * @package Krugozor\Cover
 * @author Vasiliy Makogon
 * @link https://github.com/Vasiliy-Makogon/Cover
 */
class CoverArray implements IteratorAggregate, Countable, ArrayAccess
{
    use Simple;

    /** @var array */
    private static array $reflectionStore = [];

    /**
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        $this->setData($data);
    }

    /**
     * Override this method as you see fit.
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * @param string $key
     * @param mixed $value
     * @see Simple
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $this->array2cover($value);
    }

    /**
     * @param iterable|null $data
     * @return static
     */
    public function setData(?iterable $data): static
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $this->array2cover($value);
            }
        }

        return $this;
    }

    /**
     * Implementing the Countable interface.
     *
     * @return int
     */
    final public function count(): int
    {
        return count($this->data);
    }

    /**
     * Implementing the IteratorAggregate interface.
     *
     * @return Traversable
     */
    final public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Implementation of the ArrayAccess::offsetSet interface method.
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
     * Implementation of the ArrayAccess::offsetGet interface method.
     *
     * @param mixed $offset
     * @return mixed
     */
    final public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * Implementation of the ArrayAccess::offsetExists interface method.
     *
     * @param mixed $offset
     * @return bool
     */
    final public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * Implementation of the ArrayAccess::offsetUnset interface method.
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
     * @return array
     */
    final public function __serialize(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    final public function __unserialize(array $data): void
    {
        $this->setData($data);
    }

    /**
     * Returns the current object's data as a native PHP array.
     *
     * @return array
     */
    final public function getDataAsArray(): array
    {
        $data = [];
        foreach ($this->getData() as $key => $value) {
            $data[$key] = is_a($value, self::class) ? $value->{__FUNCTION__}() : $value;
        }

        return $data;
    }

    /**
     * Returns data by keys of the current object using dot notation.
     * Example:
     *    $cover->get('prop.prop2.prop3');
     *    $cover->get('prop.prop2.0');
     *
     * @param string $path
     * @return mixed|static
     */
    final public function get(string $path): mixed
    {
        if ($path === '') {
            return null;
        }

        [0 => $key, 1 => $other] = array_pad(explode('.', $path, 2), 2, null);

        $actual_data = $this->data[$key] ?? null;

        // The keys in the chain of succession have run out.
        if ($other === null) {
            return $actual_data;
        }

        // Attempting to invoke key on a scalar value or on an object value other than static
        if (!is_object($actual_data) || !$actual_data instanceof static) {
            return null;
        }

        return $this->data[$key]->get($other);
    }

    /**
     * Analogue of the PHP function explode
     *
     * @param string $separator
     * @param string $string
     * @param int $limit
     * @return static
     * @throws ValueError
     * @see explode()
     */
    final public static function fromExplode(string $separator, string $string, int $limit = PHP_INT_MAX): static
    {
        return new static(explode($separator, $string, $limit));
    }

    /**
     * Analogue of the PHP function implode
     *
     * @param string $separator
     * @return string
     * @see implode()
     */
    final public function implode(string $separator): string
    {
        return implode($separator, $this->data);
    }

    // Start implementing aliases for PHP functions

    /**
     * Changes the case of all keys in an array.
     * Analogue of the PHP function array_change_key_case.
     *
     * @param int $case
     * @return static
     * @see array_change_key_case()
     */
    final public function changeKeyCase(int $case = CASE_LOWER): static
    {
        return new static(array_change_key_case($this->data, $case));
    }

    /**
     * Split an array into chunks.
     * Analogue of the PHP function chunk.
     *
     * @param int $length
     * @param bool $preserve_keys
     * @return static
     * @throws ValueError
     * @see array_chunk()
     */
    final public function chunk(int $length, bool $preserve_keys = false): static
    {
        return new static(
            array_chunk($this->data, $length, $preserve_keys)
        );
    }

    /**
     * Return the values from a single column in the input array.
     * Analogue of the PHP function column.
     *
     * @param int|string|null $column_key
     * @param int|string|null $index_key
     * @return static
     * @see array_column()
     */
    final public function column(int|string|null $column_key, int|string|null $index_key = null): static
    {
        return new static(
            array_column($this->data, $column_key, $index_key)
        );
    }

    /**
     * Creates an array by using one array for keys and another for its values.
     * An analogue of the PHP function combine, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array $keys
     * @param CoverArray|array $values
     * @return static
     * @see array_combine()
     */
    final public static function combine(CoverArray|array $keys, CoverArray|array $values): static
    {
        return new static(array_combine(
            (new static($keys))->getDataAsArray(),
            (new static($values))->getDataAsArray()
        ));
    }

    /**
     * Counts the occurrences of each distinct value in an array.
     * Analogue of the PHP function array_count_values.
     *
     * @return static
     * @see array_count_values()
     */
    final public function countValues(): static
    {
        return new static(array_count_values($this->getDataAsArray()));
    }

    /**
     * Computes the difference of arrays.
     * An analogue of the PHP function array_diff, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_diff()
     */
    final public function diff(CoverArray|array ...$arrays): static
    {
        return new static(array_diff(
            $this->data,
            ...(new static($arrays))->getDataAsArray()
        ));
    }

    /**
     * Computes the difference of arrays with additional index check.
     * An analogue of the PHP function array_diff_assoc, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_diff_assoc()
     */
    final public function diffAssoc(CoverArray|array ...$arrays): static
    {
        return new static(array_diff_assoc(
            $this->data,
            ...(new static($arrays))->getDataAsArray()
        ));
    }

    /**
     * Computes the difference of arrays using keys for comparison.
     * An analogue of the PHP function array_diff_assoc, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_diff_key()
     */
    final public function diffKey(CoverArray|array ...$arrays): static
    {
        return new static(array_diff_key(
            $this->data,
            ...(new static($arrays))->getDataAsArray()
        ));
    }

    /**
     * Computes the difference of arrays with additional index check which
     * is performed by a user supplied callback function.
     * An analogue of the PHP function array_diff_uassoc, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param callable $key_compare_func
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_diff_uassoc()
     */
    final public function diffUassoc(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        $args = array_merge([$this->data], [...(new static($arrays))->getDataAsArray()]);
        $args[] = $key_compare_func;

        return new static(
            call_user_func_array('array_diff_uassoc', $args)
        );
    }

    /**
     * Computes the difference of arrays using a callback function on the keys for comparison
     * An analogue of the PHP function array_diff_ukey, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param callable $key_compare_func
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_diff_ukey()
     */
    final public function diffUkey(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        $args = array_merge([$this->data], [...(new static($arrays))->getDataAsArray()]);
        $args[] = $key_compare_func;

        return new static(
            call_user_func_array('array_diff_ukey', $args)
        );
    }

    /**
     * Fill an array with values.
     * Analogue of the PHP function array_fill.
     *
     * @param int $start_index
     * @param int $count
     * @param mixed $value
     * @return static
     * @see array_fill()
     */
    final public static function fill(int $start_index, int $count, mixed $value): static
    {
        return new static(
            array_fill($start_index, $count, $value)
        );
    }

    /**
     * Fill an array with values, specifying keys.
     * Analogue of the PHP function array_fill_keys.
     *
     * @param CoverArray|array $keys
     * @param mixed $value
     * @return static
     * @see array_fill_keys
     */
    final public static function fillKeys(CoverArray|array $keys, mixed $value): static
    {
        return new static(
            array_fill_keys((new static($keys))->getDataAsArray(), $value)
        );
    }

    /**
     * Filters elements of an array using a callback function.
     * Analogue of the PHP function array_filter.
     *
     * @param callable|null $callback
     * @param int $mode
     * @return static
     * @see array_filter()
     */
    final public function filter(?callable $callback = null, int $mode = 0): static
    {
        return new static(array_filter($this->data, $callback, $mode));
    }

    /**
     * Returns the first element satisfying a callback function.
     * Analogue of the PHP function array_find.
     *
     * @param callable $callback callback(mixed $value, mixed $key): bool
     * @return mixed
     * @see array_find()
     */
    final public function find(callable $callback): mixed
    {
        return array_find($this->data, $callback);
    }

    /**
     * Returns the key of the first element satisfying a callback function.
     * Analogue of the PHP function array_find_key.
     *
     * @param callable $callback
     * @return mixed
     * @see array_find_key()
     */
    final public function findKey(callable $callback): mixed
    {
        return array_find_key($this->data, $callback);
    }

    /**
     * Exchanges all keys with their associated values in an array.
     * Analogue of the PHP function array_flip.
     *
     * @return static
     * @see array_flip()
     */
    final public function flip(): static
    {
        return new static(array_flip($this->data));
    }

    /**
     * Computes the intersection of arrays.
     * An analogue of the PHP function array_intersect, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_intersect()
     */
    final public function intersect(CoverArray|array ...$arrays): static
    {
        return new static(array_intersect($this->data, ...(new static($arrays))->getDataAsArray()));
    }

    /**
     * Computes the intersection of arrays with additional index check.
     * An analogue of the PHP function array_intersect_assoc, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_intersect_assoc()
     */
    final public function intersectAssoc(CoverArray|array ...$arrays): static
    {
        return new static(array_intersect_assoc($this->data, ...(new static($arrays))->getDataAsArray()));
    }


    ///
    ///
    ///
    ///
    ///
    ///

    /**
     * Return an array with elements in reverse order.
     * Analogue of the PHP function array_reverse.
     *
     * @param bool $preserve_keys
     * @return static
     * @see array_reverse()
     */
    final public function reverse(bool $preserve_keys = false): static
    {
        return new static(array_reverse($this->data, $preserve_keys));
    }

    /**
     * Return all the values of an array.
     * Analogue of the PHP function array_values.
     *
     * @return static
     * @see array_values()
     */
    final public function values(): static
    {
        return new static(array_values($this->data));
    }

    /**
     * Removes duplicate values from an array.
     * Analogue of the PHP function array_unique.
     *
     * @param int $flags
     * @return static
     * @see array_unique()
     */
    final public function unique(int $flags = SORT_STRING): static
    {
        return new static(array_unique($this->data, $flags));
    }

    /**
     * Return all the keys or a subset of the keys of an array.
     * Analogue of the PHP function array_keys.
     *
     * @param mixed $filter_value
     * @param bool $strict
     * @return static
     * @see array_keys()
     */
    final public function keys(mixed $filter_value = null, bool $strict = false): static
    {
        return new static(
            $filter_value !== null && $strict
                ? array_keys($this->data, $filter_value, $strict)
                : array_keys($this->data)
        );
    }

    /**
     * Prepend one or more elements to the beginning of an array.
     * Analogue of the PHP function array_unshift.
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
     * Prepend one or more elements to the beginning of an array.
     * prepend() method alias.
     *
     * @param mixed ...$args
     * @return static
     * @see static::prepend()
     */
    final public function unshift(mixed ...$args): static
    {
        return $this->prepend(...$args);
    }

    /**
     * Push one or more elements onto the end of array.
     * Analogue of the PHP function array_push.
     *
     * @param mixed ...$args
     * @return static
     */
    final public function append(mixed ...$args): static
    {
        foreach ($args as $value) {
            $this->data[] = $this->array2cover($value);
        }

        return $this;
    }

    /**
     * Push one or more elements onto the end of array.
     * append() method alias
     *
     * @param mixed ...$args
     * @return static
     * @see static::append()
     */
    final public function push(mixed ...$args): static
    {
        return $this->append(...$args);
    }

    /**
     * Returns the first element of the current array.
     *
     * @return mixed
     */
    final public function getFirst(): mixed
    {
        if ($this->count() && ($firstElement = reset($this->data)) !== null) {
            return $firstElement;
        }

        return null;
    }

    /**
     * Returns the last element of the current array.
     *
     * @return mixed
     */
    final public function getLast(): mixed
    {
        if ($this->count() && ($lastElement = end($this->data)) !== null) {
            reset($this->data);
            return $lastElement;
        }

        return null;
    }


    /**
     * Applies a callback function to all elements of an object of the current type and
     * returns a new instance of an object of the current type.
     * Example of a callback function: fn(mixed $value, mixed $key): string => "$key: $value"
     *
     * @param callable $callback
     * @return static
     * @see array_map()
     */
    final public function map(callable $callback): static
    {
        return new static(array_map($callback, array_values($this->data), array_keys($this->data)));
    }

    /**
     * Applies a callback function to all elements of a multidimensional object of the current type and
     * returns a new instance of the object of the current type.
     * Example of a callback function: fn(mixed $value, mixed $key): string => "$key: $value"
     *
     * @param callable $callback The callback function takes two arguments.
     * The first is the value of the array element, and the second is the key or index of the element.
     * @return static
     * @see array_walk_recursive()
     */
    final public function mapRecursive(callable $callback): static
    {
        return new static((function (callable $callback, array $arr) {
            array_walk_recursive($arr, function (&$v, $k) use ($callback) {
                $v = $callback($v, $k);
            });

            return $arr;
        })($callback, $this->getDataAsArray()));
    }


    /**
     * Checks if a value exists in an array.
     * Analogue of the PHP function in_array.
     *
     * @param mixed $needle
     * @param bool $strict
     * @return bool
     * @see in_array()
     */
    final public function in(mixed $needle, bool $strict = false): bool
    {
        return in_array($needle, $this->data, $strict);
    }

    /**
     * Returns a new instance of an object of the current type if the value passed to the method is an array.
     * Nested array elements also become an object of the current type.
     *
     * @param mixed $value
     * @return mixed|static
     */
    final protected function array2cover(mixed $value): mixed
    {
        return is_array($value) ? new static($value) : $value;
    }
}