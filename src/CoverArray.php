<?php

declare(strict_types=1);

namespace Krugozor\Cover;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use Countable;
use IteratorAggregate;
use ReflectionException;
use ReflectionFunction;
use Traversable;
use ValueError;

/**
 * @package Krugozor\Cover
 * @author Vasiliy Makogon
 * @link https://github.com/Vasiliy-Makogon/Cover
 *
 * @method self changeKeyCase(int $case = CASE_LOWER)
 * @method self chunk(int $length, bool $preserve_keys = false)
 * @method self column(int|string|null $column_key, int|string|null $index_key = null)
 * @method self countValues()
 * @method self diff(array|CoverArray ...$args)
 * @method self diffAssoc(array|CoverArray ...$args)
 * @method self diffKey(array|CoverArray ...$arrays)
 *
 * @method int|float sum()
 *
 */
class CoverArray implements IteratorAggregate, Countable, ArrayAccess
{
    use Simple;

    /** @var array */
    private array $reflectionStore = [];

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

    /**
     * The method executes ALL functions with the `array_` prefix that return an array data type.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws ReflectionException
     * @throws BadMethodCallException
     */
    final public function __call(string $name, array $arguments): mixed
    {
        $nativeFunctionName = 'array_' . static::camelCaseToProperty($name);

        if (!is_callable($nativeFunctionName)) {
            throw new BadMethodCallException(sprintf(
                '%s: `%s` is not callable', __METHOD__, $nativeFunctionName
            ));
        }

        if (!in_array($nativeFunctionName, $this->reflectionStore)) {
            $reflectionFunction = new ReflectionFunction($nativeFunctionName);
            if (!$parameters = $reflectionFunction->getParameters()) {
                throw new BadMethodCallException(sprintf(
                    '%s: `%s` has not parameters',
                    __METHOD__,
                    $nativeFunctionName
                ));
            }

            if ($parameters[0]->getName() != 'array') {
                throw new BadMethodCallException(sprintf(
                    '%s: first parameter of the function `%s` must be declared as `array`',
                    __METHOD__,
                    $nativeFunctionName
                ));
            }

            $this->reflectionStore[] = [$nativeFunctionName];
        }

        $result = call_user_func_array(
            $nativeFunctionName,
            array_merge(
                [$this->getDataAsArray()],
                ((new static($arguments))->getDataAsArray())
            )
        );

        return is_array($result) ? new static($result) : $result;
    }

    // Start implementing aliases for functions for working with arrays that cannot be called
    // via the __call magic method:

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

    /**
     * @param string $method_name
     * @return string
     */
    final protected static function camelCaseToProperty(string $method_name): string
    {
        $args = preg_split('/(?<=\w)(?=[A-Z])/', $method_name);

        return strtolower(implode('_', $args));
    }
}