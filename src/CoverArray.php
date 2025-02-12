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

        if (!($actual_data instanceof self) || !method_exists($actual_data, 'get')) {
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
        return new static(
            explode($separator, $string, $limit)
        );
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
     * Checks if all array elements satisfy a callback function.
     * Analogue of the PHP function array_all.
     *
     * @param callable $callback The callback function to call to check each element, which must be
     * callback(mixed $value, mixed $key): bool
     * @return bool The function returns true, if callback returns true for all elements.
     * Otherwise the function returns false.
     * @author Joshua Rüsweg, josh@php.net
     * @see https://wiki.php.net/rfc/array_find#array_all
     * @see array_all()
     */
    final public function all(callable $callback): bool
    {
        if (!function_exists('array_all')) {
            foreach ($this->data as $key => $value) {
                if (!$callback($value, $key)) {
                    return false;
                }
            }

            return true;
        }

        return array_all($this->data, $callback);
    }

    /**
     * Checks if at least one array element satisfies a callback function.
     * Analogue of the PHP function array_any.
     *
     * @param callable $callback The callback function to call to check each element, which must be
     * callback(mixed $value, mixed $key): bool
     * @return bool The function returns true, if there is at least one element for which callback returns true.
     * Otherwise the function returns false.
     * @author Joshua Rüsweg, josh@php.net
     * @see https://wiki.php.net/rfc/array_find#array_any
     * @see array_any()
     */
    final public function any(callable $callback): bool
    {
        if (!function_exists('array_any')) {
            foreach ($this->data as $key => $value) {
                if ($callback($value, $key)) {
                    return true;
                }
            }

            return false;
        }

        return array_any($this->data, $callback);
    }

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
        return new static(
            array_change_key_case($this->data, $case)
        );
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
        return new static(
            array_combine(
                is_a($keys, self::class) ? $keys->getDataAsArray() : $keys,
                is_a($values, self::class) ? $values->getDataAsArray() : $values
            )
        );
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
        return new static(
            array_count_values($this->data)
        );
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
            $this->getDataAsArray(),
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
            $this->getDataAsArray(),
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
            $this->getDataAsArray(),
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
        $args = array_merge([$this->getDataAsArray()], [...(new static($arrays))->getDataAsArray()]);
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
        $args = array_merge([$this->getDataAsArray()], [...(new static($arrays))->getDataAsArray()]);
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
            array_fill_keys(
                (new static($keys))->getDataAsArray(),
                $value
            )
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
        return new static(
            array_filter($this->data, $callback, $mode)
        );
    }

    /**
     * Returns the first element satisfying a callback function.
     * Analogue of the PHP function array_find.
     *
     * @param callable $callback The callback function to call to check each element, which must be
     * callback(mixed $value, mixed $key): bool
     * @return bool The function returns the value of the first element for which the callback returns true.
     * If no matching element is found the function returns null.
     * @author Joshua Rüsweg, josh@php.net
     * @see https://wiki.php.net/rfc/array_find#array_find
     * @see array_find()
     */
    final public function find(callable $callback): mixed
    {
        if (!function_exists('array_find')) {
            foreach ($this->data as $key => $value) {
                if ($callback($value, $key)) {
                    return $value;
                }
            }

            return null;
        }

        return array_find($this->data, $callback);
    }

    /**
     * Returns the key of the first element satisfying a callback function.
     * Analogue of the PHP function array_find_key.
     *
     * @param callable $callback The callback function to call to check each element, which must be
     * callback(mixed $value, mixed $key): bool
     * @return mixed The function returns the key of the first element for which the callback returns true.
     * If no matching element is found the function returns null.
     * @author Joshua Rüsweg, josh@php.net
     * @see https://wiki.php.net/rfc/array_find#array_find_key
     * @see array_find_key()
     */
    final public function findKey(callable $callback): mixed
    {
        if (!function_exists('array_find_key')) {
            foreach ($this->data as $key => $value) {
                if ($callback($value, $key)) {
                    return $key;
                }
            }

            return null;
        }

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
        return new static(
            array_flip($this->data)
        );
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
        return new static(
            array_intersect(
                $this->data,
                ...(new static($arrays))->getDataAsArray()
            )
        );
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
        return new static(
            array_intersect_assoc(
                $this->data,
                ...(new static($arrays))->getDataAsArray()
            )
        );
    }

    /**
     * Computes the intersection of arrays using keys for comparison.
     * An analogue of the PHP function array_intersect_key, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_intersect_key()
     */
    final public function intersectKey(CoverArray|array ...$arrays): static
    {
        return new static(
            array_intersect_key(
                $this->data,
                ...(new static($arrays))->getDataAsArray()
            )
        );
    }

    /**
     * Computes the intersection of arrays with additional index check, compares indexes by a callback function.
     * An analogue of the PHP function array_intersect_uassoc, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param callable $key_compare_func
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_intersect_uassoc()
     */
    final public function intersectUassoc(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        $args = array_merge([$this->data], [...(new static($arrays))->getDataAsArray()]);
        $args[] = $key_compare_func;

        return new static(
            call_user_func_array('array_intersect_uassoc', $args)
        );
    }

    /**
     * Computes the intersection of arrays using a callback function on the keys for comparison.
     * An analogue of the PHP function array_intersect_ukey, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param callable $key_compare_func
     * @param CoverArray|array ...$arrays
     * @return $this
     */
    final public function intersectUkey(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        $args = array_merge([$this->data], [...(new static($arrays))->getDataAsArray()]);
        $args[] = $key_compare_func;

        return new static(
            call_user_func_array('array_intersect_ukey', $args)
        );
    }

    /**
     * Checks whether a given array is a list.
     * Analogue of the PHP function array_is_list.
     *
     * @return bool
     * @author Mark Amery
     * @see https://stackoverflow.com/a/173479/24207350
     * @see array_is_list()
     */
    final public function isList(): bool
    {
        if (!function_exists('array_is_list')) {
            if ($this->data === []) {
                return true;
            }

            return array_keys($this->data) === range(0, $this->count() - 1);
        }

        return array_is_list($this->data);
    }

    /**
     * Checks if the given key or index exists in the array.
     * Analogue of the PHP function array_key_exists.
     *
     * @param mixed $key
     * @return bool
     * @see array_key_exists()
     */
    final public function keyExists(mixed $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Gets the first key of an array.
     * Analogue of the PHP function array_key_first.
     *
     * @return int|string|null
     * @see array_key_first()
     */
    final public function keyFirst(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Gets the last key of an array.
     * Analogue of the PHP function array_key_last.
     *
     * @return int|string|null
     * @see array_key_last()
     */
    final public function keyLast(): int|string|null
    {
        return array_key_last($this->data);
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
            $filter_value !== null
                ? array_keys($this->data, $filter_value, $strict)
                : array_keys($this->data)
        );
    }

    /**
     * Applies the callback to the elements of the given arrays.
     * Analogue of the PHP function array_map.
     *
     * @param callable $callback
     * @param CoverArray|array ...$arrays
     * @return static
     * @see array_map()
     * @see static::each()
     */
    final public function map(callable $callback, CoverArray|array ...$arrays): static
    {
        $args = array_merge([$this->data], [...(new static($arrays))->getDataAsArray()]);

        return new static(
            array_map($callback, ...$args)
        );
    }

    /**
     * Merge one or more arrays.
     * An analogue of the PHP function array_merge, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     */
    final public function merge(CoverArray|array ...$arrays): static
    {
        return new static(
            array_merge(
                $this->getDataAsArray(),
                ...(new static($arrays))->getDataAsArray()
            )
        );
    }

    /**
     * Merge one or more arrays recursively.
     * An analogue of the PHP function array_merge_recursive, but accepts not only arrays as arguments,
     * but also objects derived from the CoverArray class.
     *
     * @param CoverArray|array ...$arrays
     * @return static
     */
    final public function mergeRecursive(CoverArray|array ...$arrays): static
    {
        return new static(
            array_merge_recursive(
                $this->getDataAsArray(),
                ...(new static($arrays))->getDataAsArray()
            )
        );
    }

    ///
    ///
    ///
    ///
    ///
    ///

    /**
     * Applies the callback to the elements of the given arrays.
     *
     * @param callable $callback callback(mixed $value, mixed $key)
     * @return static
     * @see static::map()
     */
    final public function each(callable $callback): static
    {
        return $this->map($callback, $this->keys());
    }

    /**
     * Applies a callback function to all elements of a multidimensional object of the current type and
     * returns a new instance of the object of the current type.
     * Example of a callback function: fn(mixed $value, mixed $key): string => "$key: $value"
     *
     * @param callable $callback callback(mixed $value, mixed $key)
     * @return static
     */
    final public function eachRecursive(callable $callback): static
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
     * Return an array with elements in reverse order.
     * Analogue of the PHP function array_reverse.
     *
     * @param bool $preserve_keys
     * @return static
     * @see array_reverse()
     */
    final public function reverse(bool $preserve_keys = false): static
    {
        return new static(
            array_reverse($this->data, $preserve_keys)
        );
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
        return new static(
            array_values($this->data)
        );
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
        return new static(
            array_unique($this->data, $flags)
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