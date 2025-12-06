<?php

declare(strict_types=1);

namespace Krugozor\Cover;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use RuntimeException;
use Traversable;
use ValueError;
use JsonException;

/**
 * CoverArray - Object-oriented wrapper for PHP arrays.
 *
 * This class provides an object-oriented interface for working with arrays,
 * implementing many of PHP's native array functions as methods while adding
 * additional functionality like dot notation access, JSON serialization,
 * and support for method chaining.
 *
 *
 * CoverArray - Объектно-ориентированная обертка для PHP массивов.
 *
 * Этот класс предоставляет объектно-ориентированный интерфейс для работы с массивами,
 * реализуя многие из нативных функций PHP для массивов в виде методов, добавляя
 * дополнительную функциональность, такую как доступ через точечную нотацию,
 * сериализацию в JSON и поддержку цепочек вызовов методов.
 *
 * @package Krugozor\Cover
 * @author Vasiliy Makogon
 * @link https://github.com/Vasiliy-Makogon/Cover
 */
class CoverArray implements IteratorAggregate, Countable, ArrayAccess, JsonSerializable
{
    use Simple;

    /**
     * Constructs a new CoverArray instance.
     *
     * Initializes the object with the provided data. If null is passed,
     * an empty array is created. The data is automatically converted
     * where nested arrays become CoverArray instances.
     *
     *
     * Конструирует новый экземпляр CoverArray.
     *
     * Инициализирует объект с предоставленными данными. Если передано null,
     * создается пустой массив. Данные автоматически преобразуются,
     * где вложенные массивы становятся экземплярами CoverArray.
     *
     * @param iterable|null $data Initial data to populate the array.
     *                            Начальные данные для заполнения массива.
     */
    public function __construct(?iterable $data = null)
    {
        if ($data !== null) {
            $this->setData($data);
        }
    }

    /**
     * Checks if the array is empty.
     *
     * Returns true if the array contains no elements, false otherwise.
     * This method provides a more readable alternative to checking count() > 0.
     *
     *
     * Проверяет, является ли массив пустым.
     *
     * Возвращает true, если массив не содержит элементов, иначе false.
     * Этот метод предоставляет более читаемую альтернативу проверке count() > 0.
     *
     * @return bool True if the array is empty, false otherwise.
     *              Возвращает true, если массив пуст, иначе false.
     */
    final public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Returns a string representation of the object.
     *
     * This method can be overridden in child classes to provide
     * custom string representation. By default, returns an empty string.
     *
     *
     * Возвращает строковое представление объекта.
     *
     * Этот метод может быть переопределен в дочерних классах для предоставления
     * пользовательского строкового представления. По умолчанию возвращает пустую строку.
     *
     * @return string String representation of the object.
     *                Строковое представление объекта.
     */
    public function __toString()
    {
        return '';
    }

    /**
     * Sets a property value using object property syntax.
     *
     * Allows setting array elements using object property syntax (e.g., $obj->key = 'value').
     * The value is automatically converted to CoverArray if it's an array.
     *
     *
     * Устанавливает значение свойства с использованием синтаксиса свойств объекта.
     *
     * Позволяет устанавливать элементы массива с использованием синтаксиса свойств объекта
     * (например, $obj->key = 'value'). Значение автоматически преобразуется в CoverArray, если это массив.
     *
     * @param string $key Property name / array key.
     *                    Имя свойства / ключ массива.
     * @param mixed $value Value to set.
     *                     Значение для установки.
     * @see Simple
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $this->array2cover($value);
    }

    /**
     * Sets the internal data for the CoverArray.
     *
     * Replaces all existing data with the provided iterable, converting
     * nested arrays to CoverArray instances recursively.
     *
     *
     * Устанавливает внутренние данные для CoverArray.
     *
     * Заменяет все существующие данные предоставленным итерируемым объектом,
     * преобразуя вложенные массивы в экземпляры CoverArray рекурсивно.
     *
     * @param iterable|null $data Data to set, or null to clear the array.
     *                            Данные для установки или null для очистки массива.
     * @return static Returns the current instance for method chaining.
     *                Возвращает текущий экземпляр для цепочек вызовов.
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
     * Creates a shallow copy of the object with deep cloning of immediate object properties.
     *
     * This magic method is automatically called when using the `clone` keyword on an instance.
     * It performs a deep copy only on the first level of object elements in the data array,
     * cloning all object values while leaving scalar values and arrays as references.
     * This prevents unintended shared object state between cloned instances while
     * maintaining reasonable performance.
     *
     *
     * Создает поверхностную копию объекта с глубоким клонированием непосредственных свойств-объектов.
     *
     * Этот магический метод автоматически вызывается при использовании ключевого слова `clone` для экземпляра.
     * Он выполняет глубокое копирование только на первом уровне элементов-объектов в массиве данных,
     * клонируя все объектные значения, в то время как скалярные значения и массивы остаются ссылками.
     * Это предотвращает непреднамеренное совместное использование состояния объектов между клонированными
     * экземплярами при сохранении разумной производительности.
     *
     * @return void
     *
     * @note This implementation does not handle deep cloning of nested objects within objects.
     *       Use serialization/deserialization for complete deep copies if needed.
     *
     * @note Эта реализация не обрабатывает глубокое клонирование вложенных объектов внутри объектов.
     *       Используйте сериализацию/десериализацию для полных глубоких копий при необходимости.
     *
     * @see https://www.php.net/manual/en/language.oop5.cloning.php
     * @see CoverArray::copy()
     */
    public function __clone()
    {
        $this->data = array_map(function ($item) {
            return is_object($item) ? clone $item : $item;
        }, $this->data);
    }

    /**
     * Creates and returns a copy of the current object instance.
     *
     * This method provides a convenient public interface for object copying,
     * internally utilizing the `__clone()` magic method. It returns a new instance
     * where all immediate object properties are cloned, ensuring independent
     * state management between the original and copied objects.
     *
     * The method is marked as final to maintain consistent copying behavior
     * across all subclasses, preventing potential issues with inheritance chains.
     *
     *
     * Создает и возвращает копию текущего экземпляра объекта.
     *
     * Этот метод предоставляет удобный публичный интерфейс для копирования объектов,
     * внутренне используя магический метод `__clone()`. Он возвращает новый экземпляр,
     * в котором все непосредственные свойства-объекты клонируются, обеспечивая
     * независимое управление состоянием между исходным и скопированным объектами.
     *
     * Метод помечен как final для поддержания согласованного поведения копирования
     * во всех подклассах, предотвращая потенциальные проблемы с цепочками наследования.
     *
     * @return static A new instance of the current class with cloned object properties.
     *                Возвращает новый экземпляр текущего класса с клонированными свойствами-объектами.
     *
     * @example
     * $original = new CoverArray(['obj' => new stdClass()]);
     * $copy = $original->copy();
     * $copy['obj']->property = 'changed'; // Does not affect $original
     *
     * @see CoverArray::__clone()
     * @see https://www.php.net/manual/en/language.oop5.cloning.php
     */
    final public function copy(): static
    {
        return clone $this;
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
     * Implements the IteratorAggregate interface.
     *
     * Returns an iterator for the array, allowing foreach loops to work.
     *
     *
     * Реализует интерфейс IteratorAggregate.
     *
     * Возвращает итератор для массива, позволяя работать с циклами foreach.
     *
     * @return Traversable Iterator for the array data.
     *                     Итератор для данных массива.
     */
    final public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Implements the ArrayAccess::offsetSet interface method.
     *
     * Sets the value at the specified offset. If offset is null,
     * the value is appended to the end of the array.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetSet.
     *
     * Устанавливает значение по указанному смещению. Если смещение равно null,
     * значение добавляется в конец массива.
     *
     * @param mixed $offset The offset to assign the value to.
     *                      Смещение для присвоения значения.
     * @param mixed $value The value to set.
     *                     Устанавливаемое значение.
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
     * Implements the ArrayAccess::offsetGet interface method.
     *
     * Returns the value at the specified offset, or null if the offset doesn't exist.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetGet.
     *
     * Возвращает значение по указанному смещению или null, если смещение не существует.
     *
     * @param mixed $offset The offset to retrieve.
     *                      Смещение для получения значения.
     * @return mixed Value at the specified offset or null.
     *               Значение по указанному смещению или null.
     */
    final public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * Implements the ArrayAccess::offsetExists interface method.
     *
     * Checks whether the specified offset exists in the array.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetExists.
     *
     * Проверяет, существует ли указанное смещение в массиве.
     *
     * @param mixed $offset The offset to check.
     *                      Смещение для проверки.
     * @return bool True if the offset exists, false otherwise.
     *              Возвращает true, если смещение существует, иначе false.
     */
    final public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * Implements the ArrayAccess::offsetUnset interface method.
     *
     * Unsets the value at the specified offset if it exists.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetUnset.
     *
     * Удаляет значение по указанному смещению, если оно существует.
     *
     * @param mixed $offset The offset to unset.
     *                      Смещение для удаления.
     */
    final public function offsetUnset(mixed $offset): void
    {
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Serializes the object for serialization.
     *
     * Returns an array representation of the object suitable for serialization.
     * This method is called by serialize() and the serialization mechanism.
     *
     *
     * Сериализует объект для сериализации.
     *
     * Возвращает представление объекта в виде массива, пригодное для сериализации.
     * Этот метод вызывается функцией serialize() и механизмом сериализации.
     *
     * @return array Array representation of the object.
     *               Представление объекта в виде массива.
     */
    final public function __serialize(): array
    {
        return $this->getData();
    }

    /**
     * Unserializes the object from serialized data.
     *
     * Restores the object state from serialized data array.
     *
     *
     * Десериализует объект из сериализованных данных.
     *
     * Восстанавливает состояние объекта из сериализованного массива данных.
     *
     * @param array $data Serialized data to restore from.
     *                    Сериализованные данные для восстановления.
     */
    final public function __unserialize(array $data): void
    {
        $this->setData($data);
    }

    /**
     * Returns the current object's data as a native PHP array.
     *
     * Converts all nested CoverArray instances to plain PHP arrays recursively,
     * providing a complete native array representation of the data structure.
     *
     *
     * Возвращает данные текущего объекта в виде обычного массива PHP.
     *
     * Преобразует все вложенные экземпляры CoverArray в обычные массивы PHP рекурсивно,
     * предоставляя полное представление структуры данных в виде нативного массива.
     *
     * @return array Native PHP array representation of the data.
     *               Представление данных в виде обычного массива PHP.
     */
    final public function getDataAsArray(): array
    {
        $data = [];
        foreach ($this->getData() as $key => $value) {
            $data[$key] = $value instanceof self ? $value->{__FUNCTION__}() : $value;
        }

        return $data;
    }

    /**
     * Returns data by keys of the current object using dot notation.
     *
     * Allows accessing nested array elements using dot notation (e.g., 'user.profile.name').
     * Returns the value at the specified path or null if any segment doesn't exist.
     *
     *
     * Возвращает данные по ключам текущего объекта с использованием точечной нотации.
     *
     * Позволяет получать доступ к вложенным элементам массива с использованием точечной нотации
     * (например, 'user.profile.name'). Возвращает значение по указанному пути или null,
     * если любой сегмент не существует.
     *
     * @param string $path Dot-notation path to the desired value.
     *                     Путь в точечной нотации к желаемому значению.
     * @return mixed|static The value at the specified path or null.
     *                      Значение по указанному пути или null.
     * @throws InvalidArgumentException If the path is empty.
     *                                  Если путь пуст.
     */
    final public function get(string $path): mixed
    {
        if ($path === '') {
            throw new InvalidArgumentException('Path cannot be empty');
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
     * Specifies data which should be serialized to JSON.
     *
     * Returns data in a format that can be serialized to JSON.
     * This method is called when json_encode() is used on a CoverArray instance.
     *
     *
     * Определяет данные, которые должны быть сериализованы в JSON.
     *
     * Возвращает данные в формате, который может быть сериализован в JSON.
     * Этот метод вызывается при использовании json_encode() на экземпляре CoverArray.
     *
     * @return array Data suitable for JSON serialization.
     *               Данные, пригодные для сериализации в JSON.
     */
    final public function jsonSerialize(): array
    {
        return $this->getDataAsArray();
    }

    /**
     * Creates a CoverArray instance from a JSON string.
     *
     * Parses a JSON string and creates a new CoverArray instance with the decoded data.
     * This is a static factory method for convenient object creation from JSON.
     *
     *
     * Создает экземпляр CoverArray из строки JSON.
     *
     * Разбирает строку JSON и создает новый экземпляр CoverArray с декодированными данными.
     * Это статический фабричный метод для удобного создания объектов из JSON.
     *
     * @param string $json JSON string to parse.
     *                     Строка JSON для разбора.
     * @param int $depth Maximum recursion depth for decoding.
     *                   Максимальная глубина рекурсии для декодирования.
     * @param int $flags Bitmask of JSON decode options.
     *                   Битовая маска опций декодирования JSON.
     * @return static New CoverArray instance with decoded JSON data.
     *                Новый экземпляр CoverArray с декодированными данными JSON.
     * @throws JsonException If JSON decoding fails.
     *                       Если декодирование JSON не удалось.
     * @see json_decode()
     */
    final public static function fromJson(
        string $json,
        int $depth = 512,
        int $flags = JSON_THROW_ON_ERROR
    ): static {
        return new static(json_decode($json, true, $depth, $flags));
    }

    /**
     * Converts the CoverArray to a JSON string.
     *
     * Serializes the CoverArray data to a JSON string representation.
     *
     *
     * Преобразует CoverArray в строку JSON.
     *
     * Сериализует данные CoverArray в строковое представление JSON.
     *
     * @param int $flags Bitmask of JSON encode options.
     *                   Битовая маска опций кодирования JSON.
     * @param int $depth Maximum recursion depth for encoding.
     *                   Максимальная глубина рекурсии для кодирования.
     * @return string JSON string representation of the data.
     *                Строковое представление данных в формате JSON.
     * @throws JsonException If JSON encoding fails.
     *                       Если кодирование JSON не удалось.
     * @see json_encode()
     */
    final public function toJson(int $flags = JSON_THROW_ON_ERROR, int $depth = 512): string
    {
        return json_encode($this->getDataAsArray(), $flags, $depth);
    }

    /**
     * Creates a CoverArray from a string using explode().
     *
     * Splits a string by a separator and creates a CoverArray from the resulting array.
     * This is a static factory method equivalent to PHP's explode() function.
     *
     *
     * Создает CoverArray из строки с помощью explode().
     *
     * Разбивает строку разделителем и создает CoverArray из полученного массива.
     * Это статический фабричный метод, эквивалентный функции PHP explode().
     *
     * @param string $separator The boundary string for splitting.
     *                          Разделитель для разбиения строки.
     * @param string $string The input string to split.
     *                       Входная строка для разбиения.
     * @param int $limit Maximum number of elements to return.
     *                   Максимальное количество возвращаемых элементов.
     * @return static New CoverArray instance with exploded string parts.
     *                Новый экземпляр CoverArray с частями разбитой строки.
     * @throws ValueError If separator is empty.
     *                    Если разделитель пуст.
     * @see explode()
     */
    final public static function fromExplode(string $separator, string $string, int $limit = PHP_INT_MAX): static
    {
        return new static(
            explode($separator, $string, $limit)
        );
    }

    /**
     * Creates a CoverArray from a native PHP array.
     *
     * Static factory method for creating a CoverArray instance from a native array.
     * This provides a more explicit alternative to the constructor.
     *
     *
     * Создает CoverArray из обычного массива PHP.
     *
     * Статический фабричный метод для создания экземпляра CoverArray из нативного массива.
     * Предоставляет более явную альтернативу конструктору.
     *
     * @param array $array Native PHP array to convert.
     *                     Обычный массив PHP для преобразования.
     * @return static New CoverArray instance.
     *                Новый экземпляр CoverArray.
     */
    final public static function fromArray(array $array): static
    {
        return new static($array);
    }

    /**
     * Joins array elements with a string (implode equivalent).
     *
     * Returns a string containing a string representation of all array elements
     * in the same order, separated by the specified separator.
     *
     *
     * Объединяет элементы массива строкой (эквивалент implode).
     *
     * Возвращает строку, содержащую строковое представление всех элементов массива
     * в том же порядке, разделенных указанным разделителем.
     *
     * @param string $separator String to separate array elements.
     *                          Строка для разделения элементов массива.
     * @return string String representation of joined array elements.
     *                Строковое представление объединенных элементов массива.
     * @see implode()
     */
    final public function implode(string $separator): string
    {
        return implode($separator, $this->data);
    }

    // Start implementing aliases for PHP functions

    /**
     * Checks if all array elements satisfy a callback function (array_all equivalent).
     *
     * Tests whether all elements in the array pass the test implemented by the provided callback function.
     * Returns true if the callback returns true for all elements, false otherwise.
     *
     *
     * Проверяет, удовлетворяют ли все элементы массива callback-функции (эквивалент array_all).
     *
     * Проверяет, проходят ли все элементы массива тест, реализованный предоставленной callback-функцией.
     * Возвращает true, если callback возвращает true для всех элементов, иначе false.
     *
     * @param callable $callback Callback function to test each element, must be callback(mixed $value, mixed $key): bool.
     *                           Callback-функция для тестирования каждого элемента, должна быть callback(mixed $value, mixed $key): bool.
     * @return bool True if callback returns true for all elements, false otherwise.
     *              Возвращает true, если callback возвращает true для всех элементов, иначе false.
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
     * Checks if at least one array element satisfies a callback function (array_any equivalent).
     *
     * Tests whether at least one element in the array passes the test implemented by the provided callback function.
     * Returns true if the callback returns true for any element, false otherwise.
     *
     *
     * Проверяет, удовлетворяет ли хотя бы один элемент массива callback-функции (эквивалент array_any).
     *
     * Проверяет, проходит ли хотя бы один элемент массива тест, реализованный предоставленной callback-функцией.
     * Возвращает true, если callback возвращает true для любого элемента, иначе false.
     *
     * @param callable $callback Callback function to test each element, must be callback(mixed $value, mixed $key): bool.
     *                           Callback-функция для тестирования каждого элемента, должна быть callback(mixed $value, mixed $key): bool.
     * @return bool True if callback returns true for at least one element, false otherwise.
     *              Возвращает true, если callback возвращает true хотя бы для одного элемента, иначе false.
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
     * Changes the case of all keys in an array (array_change_key_case equivalent).
     *
     * Returns an array with all keys from the input array lowercased or uppercased.
     * Numeric keys are left as is.
     *
     *
     * Изменяет регистр всех ключей в массиве (эквивалент array_change_key_case).
     *
     * Возвращает массив со всеми ключами из входного массива в нижнем или верхнем регистре.
     * Числовые ключи остаются без изменений.
     *
     * @param int $case Either CASE_UPPER (uppercase) or CASE_LOWER (lowercase).
     *                  Либо CASE_UPPER (верхний регистр), либо CASE_LOWER (нижний регистр).
     * @return static New CoverArray instance with case-changed keys.
     *                Новый экземпляр CoverArray с измененным регистром ключей.
     * @see array_change_key_case()
     */
    final public function changeKeyCase(int $case = CASE_LOWER): static
    {
        return new static(
            array_change_key_case($this->data, $case)
        );
    }

    /**
     * Splits an array into chunks (array_chunk equivalent).
     *
     * Splits the array into smaller arrays (chunks) of the specified size.
     * The last chunk may contain fewer elements than the specified size.
     *
     *
     * Разбивает массив на части (эквивалент array_chunk).
     *
     * Разбивает массив на меньшие массивы (части) указанного размера.
     * Последняя часть может содержать меньше элементов, чем указанный размер.
     *
     * @param int $length Size of each chunk.
     *                    Размер каждой части.
     * @param bool $preserve_keys Whether to preserve keys from the original array.
     *                            Сохранять ли ключи из исходного массива.
     * @return static New CoverArray instance containing array chunks.
     *                Новый экземпляр CoverArray, содержащий части массива.
     * @throws ValueError If length is less than 1.
     *                    Если размер меньше 1.
     * @see array_chunk()
     */
    final public function chunk(int $length, bool $preserve_keys = false): static
    {
        return new static(
            array_chunk($this->data, $length, $preserve_keys)
        );
    }

    /**
     * Returns the values from a single column in the input array (array_column equivalent).
     *
     * Returns the values from a single column of the input array, identified by column key.
     * Optionally indexes the values by another column's values.
     *
     *
     * Возвращает значения из одного столбца входного массива (эквивалент array_column).
     *
     * Возвращает значения из одного столбца входного массива, идентифицированного ключом столбца.
     * Опционально индексирует значения значениями другого столбца.
     *
     * @param int|string|null $column_key Column of values to return.
     *                                    Столбец значений для возврата.
     * @param int|string|null $index_key Column to use as index/keys for the returned array.
     *                                   Столбец для использования в качестве индекса/ключей возвращаемого массива.
     * @return static New CoverArray instance containing column values.
     *                Новый экземпляр CoverArray, содержащий значения столбца.
     * @see array_column()
     */
    final public function column(int|string|null $column_key, int|string|null $index_key = null): static
    {
        return new static(
            array_column($this->data, $column_key, $index_key)
        );
    }

    /**
     * Creates an array by using one array for keys and another for values (array_combine equivalent).
     *
     * Creates a new array where values from the keys array become keys and values
     * from the values array become corresponding values.
     *
     *
     * Создает массив, используя один массив для ключей, а другой для значений (эквивалент array_combine).
     *
     * Создает новый массив, где значения из массива ключей становятся ключами,
     * а значения из массива значений становятся соответствующими значениями.
     *
     * @param CoverArray|array $keys Array of values to use as keys.
     *                               Массив значений для использования в качестве ключей.
     * @param CoverArray|array $values Array of values to use as values.
     *                                 Массив значений для использования в качестве значений.
     * @return static New CoverArray instance with combined keys and values.
     *                Новый экземпляр CoverArray с объединенными ключами и значениями.
     * @see array_combine()
     */
    final public static function combine(CoverArray|array $keys, CoverArray|array $values): static
    {
        return new static(
            array_combine(
                self::convertToPlainArray($keys),
                self::convertToPlainArray($values)
            )
        );
    }

    /**
     * Counts the occurrences of each distinct value in an array (array_count_values equivalent).
     *
     * Returns an associative array where keys are the array's values and values
     * are the number of occurrences of each value.
     *
     *
     * Подсчитывает количество вхождений каждого отдельного значения в массиве (эквивалент array_count_values).
     *
     * Возвращает ассоциативный массив, где ключи - это значения массива, а значения -
     * количество вхождений каждого значения.
     *
     * @return static New CoverArray instance with value counts.
     *                Новый экземпляр CoverArray с подсчетом значений.
     * @see array_count_values()
     */
    final public function countValues(): static
    {
        return new static(
            array_count_values($this->data)
        );
    }

    /**
     * Computes the difference of arrays (array_diff equivalent).
     *
     * Compares the current array against one or more arrays and returns the values
     * that are present in the current array but not in any of the other arrays.
     *
     *
     * Вычисляет расхождение массивов (эквивалент array_diff).
     *
     * Сравнивает текущий массив с одним или несколькими массивами и возвращает значения,
     * которые присутствуют в текущем массиве, но отсутствуют в любом из других массивов.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_diff()
     */
    final public function diff(CoverArray|array ...$arrays): static
    {
        return new static(array_diff(
            $this->getDataAsArray(),
            ...array_map(
                [self::class, 'convertToPlainArray'],
                $arrays
            )
        ));
    }

    /**
     * Computes the difference of arrays with additional index check (array_diff_assoc equivalent).
     *
     * Computes the difference of arrays with additional index/key check.
     * Unlike array_diff(), this method compares both values and keys/indices.
     *
     *
     * Вычисляет расхождение массивов с дополнительной проверкой индекса (эквивалент array_diff_assoc).
     *
     * Вычисляет расхождение массивов с дополнительной проверкой индекса/ключа.
     * В отличие от array_diff(), этот метод сравнивает как значения, так и ключи/индексы.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_diff_assoc()
     */
    final public function diffAssoc(CoverArray|array ...$arrays): static
    {
        return new static(array_diff_assoc(
            $this->getDataAsArray(),
            ...array_map(
                [self::class, 'convertToPlainArray'],
                $arrays
            )
        ));
    }

    /**
     * Computes the difference of arrays using keys for comparison (array_diff_key equivalent).
     *
     * Computes the difference of arrays by comparing keys only.
     * Returns key-value pairs from the current array whose keys are not present
     * in any of the other arrays.
     *
     *
     * Вычисляет расхождение массивов, сравнивая ключи (эквивалент array_diff_key).
     *
     * Вычисляет расхождение массивов, сравнивая только ключи.
     * Возвращает пары ключ-значение из текущего массива, ключи которых отсутствуют
     * в любом из других массивов.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_diff_key()
     */
    final public function diffKey(CoverArray|array ...$arrays): static
    {
        return new static(array_diff_key(
            $this->getDataAsArray(),
            ...array_map(
                [self::class, 'convertToPlainArray'],
                $arrays
            )
        ));
    }

    /**
     * Computes the difference of arrays with user-defined key comparison (array_diff_uassoc equivalent).
     *
     * Computes the difference of arrays with additional index check using a user-defined
     * callback function for key comparison.
     *
     *
     * Вычисляет расхождение массивов с пользовательским сравнением ключей (эквивалент array_diff_uassoc).
     *
     * Вычисляет расхождение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей.
     *
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_diff_uassoc()
     */
    final public function diffUassoc(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_diff_uassoc', array_merge(
                [$this->getDataAsArray()],
                array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                ),
                [$key_compare_func]
            ))
        );
    }

    /**
     * Computes the difference of arrays using callback function on keys (array_diff_ukey equivalent).
     *
     * Computes the difference of arrays using a callback function on the keys for comparison.
     * The callback function should return an integer less than, equal to, or greater than zero
     * if the first key is considered to be respectively less than, equal to, or greater than the second.
     *
     *
     * Вычисляет расхождение массивов, используя callback-функцию для сравнения ключей (эквивалент array_diff_ukey).
     *
     * Вычисляет расхождение массивов, используя callback-функцию для сравнения ключей.
     * Callback-функция должна возвращать целое число меньше, равно или больше нуля,
     * если первый ключ считается соответственно меньше, равен или больше второго.
     *
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_diff_ukey()
     */
    final public function diffUkey(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_diff_ukey', array_merge(
                [$this->getDataAsArray()],
                array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                ),
                [$key_compare_func]
            ))
        );
    }

    /**
     * Fills an array with values (array_fill equivalent).
     *
     * Creates a new array filled with the specified value, starting from the
     * specified start index for the specified number of elements.
     *
     *
     * Заполняет массив значениями (эквивалент array_fill).
     *
     * Создает новый массив, заполненный указанным значением, начиная с указанного
     * начального индекса для указанного количества элементов.
     *
     * @param int $start_index First index of the returned array.
     *                         Первый индекс возвращаемого массива.
     * @param int $count Number of elements to insert.
     *                   Количество вставляемых элементов.
     * @param mixed $value Value to use for filling.
     *                     Значение для заполнения.
     * @return static New CoverArray instance filled with the specified value.
     *                Новый экземпляр CoverArray, заполненный указанным значением.
     * @see array_fill()
     */
    final public static function fill(int $start_index, int $count, mixed $value): static
    {
        return new static(
            array_fill($start_index, $count, $value)
        );
    }

    /**
     * Fills an array with values, specifying keys (array_fill_keys equivalent).
     *
     * Creates a new array using the values from the keys array as keys and
     * filling all values with the specified value.
     *
     *
     * Заполняет массив значениями, указывая ключи (эквивалент array_fill_keys).
     *
     * Создает новый массив, используя значения из массива ключей в качестве ключей и
     * заполняя все значения указанным значением.
     *
     * @param CoverArray|array $keys Array of values to use as keys.
     *                               Массив значений для использования в качестве ключей.
     * @param mixed $value Value to use for filling.
     *                     Значение для заполнения.
     * @return static New CoverArray instance with filled keys.
     *                Новый экземпляр CoverArray с заполненными ключами.
     * @see array_fill_keys()
     */
    final public static function fillKeys(CoverArray|array $keys, mixed $value): static
    {
        return new static(
            array_fill_keys(
                self::convertToPlainArray($keys),
                $value
            )
        );
    }

    /**
     * Filters elements of an array using a callback function (array_filter equivalent).
     *
     * Iterates over each value in the array passing them to the callback function.
     * Returns a new array containing only the elements for which the callback function returns true.
     *
     *
     * Фильтрует элементы массива с помощью callback-функции (эквивалент array_filter).
     *
     * Перебирает каждое значение в массиве, передавая их в callback-функцию.
     * Возвращает новый массив, содержащий только элементы, для которых callback-функция возвращает true.
     *
     * @param callable|null $callback Callback function to use for filtering.
     *                                Callback-функция для использования при фильтрации.
     * @param int $mode Flag determining what arguments are sent to callback.
     *                  Флаг, определяющий, какие аргументы отправляются в callback.
     * @return static New CoverArray instance with filtered elements.
     *                Новый экземпляр CoverArray с отфильтрованными элементами.
     * @see array_filter()
     */
    final public function filter(?callable $callback = null, int $mode = 0): static
    {
        return new static(
            array_filter($this->data, $callback, $mode)
        );
    }

    /**
     * Returns the first element satisfying a callback function (array_find equivalent).
     *
     * Returns the value of the first element in the array that satisfies the provided
     * callback function. Returns null if no matching element is found.
     *
     *
     * Возвращает первый элемент, удовлетворяющий callback-функции (эквивалент array_find).
     *
     * Возвращает значение первого элемента в массиве, который удовлетворяет предоставленной
     * callback-функции. Возвращает null, если соответствующий элемент не найден.
     *
     * @param callable $callback Callback function to test each element, must be callback(mixed $value, mixed $key): bool.
     *                           Callback-функция для тестирования каждого элемента, должна быть callback(mixed $value, mixed $key): bool.
     * @return mixed Value of the first matching element or null.
     *               Значение первого соответствующего элемента или null.
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
     * Returns the key of the first element satisfying a callback function (array_find_key equivalent).
     *
     * Returns the key of the first element in the array that satisfies the provided
     * callback function. Returns null if no matching element is found.
     *
     *
     * Возвращает ключ первого элемента, удовлетворяющего callback-функции (эквивалент array_find_key).
     *
     * Возвращает ключ первого элемента в массиве, который удовлетворяет предоставленной
     * callback-функции. Возвращает null, если соответствующий элемент не найден.
     *
     * @param callable $callback Callback function to test each element, must be callback(mixed $value, mixed $key): bool.
     *                           Callback-функция для тестирования каждого элемента, должна быть callback(mixed $value, mixed $key): bool.
     * @return mixed Key of the first matching element or null.
     *               Ключ первого соответствующего элемента или null.
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
     * Exchanges all keys with their associated values in an array (array_flip equivalent).
     *
     * Returns a new array with keys and values flipped. Values become keys and keys become values.
     * Note: Duplicate values will be lost since keys must be unique.
     *
     *
     * Меняет местами все ключи с их значениями в массиве (эквивалент array_flip).
     *
     * Возвращает новый массив с поменянными местами ключами и значениями.
     * Значения становятся ключами, а ключи - значениями.
     * Примечание: Дублирующиеся значения будут потеряны, так как ключи должны быть уникальными.
     *
     * @return static New CoverArray instance with flipped keys and values.
     *                Новый экземпляр CoverArray с поменянными местами ключами и значениями.
     * @see array_flip()
     */
    final public function flip(): static
    {
        return new static(
            array_flip($this->data)
        );
    }

    /**
     * Computes the intersection of arrays (array_intersect equivalent).
     *
     * Compares the current array against one or more arrays and returns the values
     * that are present in all arrays.
     *
     *
     * Вычисляет пересечение массивов (эквивалент array_intersect).
     *
     * Сравнивает текущий массив с одним или несколькими массивами и возвращает значения,
     * которые присутствуют во всех массивах.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_intersect()
     */
    final public function intersect(CoverArray|array ...$arrays): static
    {
        return new static(
            array_intersect(
                $this->data,
                ...array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                )
            )
        );
    }

    /**
     * Computes the intersection of arrays with additional index check (array_intersect_assoc equivalent).
     *
     * Computes the intersection of arrays with additional index/key check.
     * Unlike array_intersect(), this method compares both values and keys/indices.
     *
     *
     * Вычисляет пересечение массивов с дополнительной проверкой индекса (эквивалент array_intersect_assoc).
     *
     * Вычисляет пересечение массивов с дополнительной проверкой индекса/ключа.
     * В отличие от array_intersect(), этот метод сравнивает как значения, так и ключи/индексы.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_intersect_assoc()
     */
    final public function intersectAssoc(CoverArray|array ...$arrays): static
    {
        return new static(
            array_intersect_assoc(
                $this->data,
                ...array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                )
            )
        );
    }

    /**
     * Computes the intersection of arrays using keys for comparison (array_intersect_key equivalent).
     *
     * Computes the intersection of arrays by comparing keys only.
     * Returns key-value pairs from the current array whose keys are present
     * in all the other arrays.
     *
     *
     * Вычисляет пересечение массивов, сравнивая ключи (эквивалент array_intersect_key).
     *
     * Вычисляет пересечение массивов, сравнивая только ключи.
     * Возвращает пары ключ-значение из текущего массива, ключи которых присутствуют
     * во всех других массивах.
     *
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_intersect_key()
     */
    final public function intersectKey(CoverArray|array ...$arrays): static
    {
        return new static(
            array_intersect_key(
                $this->data,
                ...array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                )
            )
        );
    }

    /**
     * Computes the intersection of arrays with user-defined key comparison (array_intersect_uassoc equivalent).
     *
     * Computes the intersection of arrays with additional index check using a user-defined
     * callback function for key comparison.
     *
     *
     * Вычисляет пересечение массивов с пользовательским сравнением ключей (эквивалент array_intersect_uassoc).
     *
     * Вычисляет пересечение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей.
     *
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_intersect_uassoc()
     */
    final public function intersectUassoc(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_intersect_uassoc', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                ),
                [$key_compare_func]
            ))
        );
    }

    /**
     * Computes the intersection of arrays using callback function on keys (array_intersect_ukey equivalent).
     *
     * Computes the intersection of arrays using a callback function on the keys for comparison.
     * The callback function should return an integer less than, equal to, or greater than zero
     * if the first key is considered to be respectively less than, equal to, or greater than the second.
     *
     *
     * Вычисляет пересечение массивов, используя callback-функцию для сравнения ключей (эквивалент array_intersect_ukey).
     *
     * Вычисляет пересечение массивов, используя callback-функцию для сравнения ключей.
     * Callback-функция должна возвращать целое число меньше, равно или больше нуля,
     * если первый ключ считается соответственно меньше, равен или больше второго.
     *
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_intersect_ukey()
     */
    final public function intersectUkey(callable $key_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_intersect_ukey', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                ),
                [$key_compare_func]
            ))
        );
    }

    /**
     * Checks whether a given array is a list (array_is_list equivalent).
     *
     * Returns true if the array keys are 0, 1, 2, ... sequentially with no gaps.
     * An empty array is considered a list.
     *
     *
     * Проверяет, представляет ли данный массив список (эквивалент array_is_list).
     *
     * Возвращает true, если ключи массива равны 0, 1, 2, ... последовательно без пропусков.
     * Пустой массив считается списком.
     *
     * @return bool True if the array is a list, false otherwise.
     *              Возвращает true, если массив является списком, иначе false.
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
     * Checks if the given key or index exists in the array (array_key_exists equivalent).
     *
     * Returns true if the given key is set in the array, false otherwise.
     * The key can be any value possible for an array index.
     *
     *
     * Проверяет, содержит ли массив указанный ключ или индекс (эквивалент array_key_exists).
     *
     * Возвращает true, если указанный ключ установлен в массиве, иначе false.
     * Ключом может быть любое значение, возможное для индекса массива.
     *
     * @param mixed $key Key or index to check for.
     *                   Ключ или индекс для проверки.
     * @return bool True if the key exists, false otherwise.
     *              Возвращает true, если ключ существует, иначе false.
     * @see array_key_exists()
     */
    final public function keyExists(mixed $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Gets the first key of an array (array_key_first equivalent).
     *
     * Returns the first key of the array without affecting the internal array pointer.
     * Returns null if the array is empty.
     *
     *
     * Получает первый ключ массива (эквивалент array_key_first).
     *
     * Возвращает первый ключ массива, не затрагивая внутренний указатель массива.
     * Возвращает null, если массив пуст.
     *
     * @return int|string|null The first key or null if array is empty.
     *                         Первый ключ или null, если массив пуст.
     * @see array_key_first()
     */
    final public function keyFirst(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Gets the last key of an array (array_key_last equivalent).
     *
     * Returns the last key of the array without affecting the internal array pointer.
     * Returns null if the array is empty.
     *
     *
     * Получает последний ключ массива (эквивалент array_key_last).
     *
     * Возвращает последний ключ массива, не затрагивая внутренний указатель массива.
     * Возвращает null, если массив пуст.
     *
     * @return int|string|null The last key or null if array is empty.
     *                         Последний ключ или null, если массив пуст.
     * @see array_key_last()
     */
    final public function keyLast(): int|string|null
    {
        return array_key_last($this->data);
    }

    /**
     * Returns all the keys or a subset of the keys of an array (array_keys equivalent).
     *
     * Returns all the keys of the array, or the keys for a specific value if filter_value is provided.
     *
     *
     * Возвращает все или некоторое подмножество ключей массива (эквивалент array_keys).
     *
     * Возвращает все ключи массива или ключи для определенного значения, если указан filter_value.
     *
     * @param mixed $filter_value If specified, only keys for this value are returned.
     *                            Если указано, возвращаются только ключи для этого значения.
     * @param bool $strict Determines if strict comparison (===) should be used.
     *                     Определяет, следует ли использовать строгое сравнение (===).
     * @return static New CoverArray instance containing the keys.
     *                Новый экземпляр CoverArray, содержащий ключи.
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
     * Applies a callback function to the elements of arrays (array_map equivalent).
     *
     * Returns a new array containing the results of applying the callback function
     * to the corresponding elements of the current array and additional arrays.
     * Note: For associative arrays, consider using the each() method instead.
     *
     *
     * Применяет callback-функцию к элементам массивов (эквивалент array_map).
     *
     * Возвращает новый массив, содержащий результаты применения callback-функции
     * к соответствующим элементам текущего массива и дополнительных массивов.
     * Примечание: Для ассоциативных массивов рассмотрите использование метода each().
     *
     * @param callable|null $callback Callback function to apply.
     *                                Callback-функция для применения.
     * @param CoverArray|array ...$arrays Additional arrays to process.
     *                                    Дополнительные массивы для обработки.
     * @return static New CoverArray instance with mapped values.
     *                Новый экземпляр CoverArray с преобразованными значениями.
     * @see array_map()
     * @see CoverArray::each()
     */
    final public function map(null|callable $callback, CoverArray|array ...$arrays): static
    {
        return new static(
            array_map(
                $callback,
                ...array_merge([$this->data],
                    array_map(
                        [self::class, 'convertToPlainArray'],
                        $arrays
                    )
                )
            )
        );
    }

    /**
     * Merges one or more arrays (array_merge equivalent).
     *
     * Merges the elements of one or more arrays together so that the values of one
     * are appended to the end of the previous one. Returns a new array.
     *
     *
     * Сливает один или несколько массивов (эквивалент array_merge).
     *
     * Объединяет элементы одного или нескольких массивов таким образом, что значения одного
     * добавляются в конец предыдущего. Возвращает новый массив.
     *
     * @param CoverArray|array ...$arrays Arrays to merge.
     *                                    Массивы для слияния.
     * @return static New CoverArray instance containing merged arrays.
     *                Новый экземпляр CoverArray, содержащий объединенные массивы.
     * @see array_merge()
     */
    final public function merge(CoverArray|array ...$arrays): static
    {
        return new static(
            array_merge(
                $this->getDataAsArray(),
                ...array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                )
            )
        );
    }

    /**
     * Recursively merges one or more arrays (array_merge_recursive equivalent).
     *
     * Merges the elements of one or more arrays together recursively so that
     * the values of one are appended to the end of the previous one.
     * If arrays have the same string keys, the values are merged into an array.
     *
     *
     * Рекурсивно сливает один или несколько массивов (эквивалент array_merge_recursive).
     *
     * Рекурсивно объединяет элементы одного или нескольких массивов таким образом, что
     * значения одного добавляются в конец предыдущего.
     * Если массивы имеют одинаковые строковые ключи, значения объединяются в массив.
     *
     * @param CoverArray|array ...$arrays Arrays to merge.
     *                                    Массивы для слияния.
     * @return static New CoverArray instance containing recursively merged arrays.
     *                Новый экземпляр CoverArray, содержащий рекурсивно объединенные массивы.
     * @see array_merge_recursive()
     */
    final public function mergeRecursive(CoverArray|array ...$arrays): static
    {
        return new static(
            array_merge_recursive(
                $this->getDataAsArray(),
                ...array_map(
                    [self::class, 'convertToPlainArray'],
                    $arrays
                )
            )
        );
    }

    /**
     * Applies a callback function to each element (array_walk equivalent for associative arrays).
     *
     * Applies a user-defined callback function to each element of the array,
     * preserving keys. The callback receives both value and key as parameters.
     * Returns a new CoverArray with the results.
     *
     *
     * Применяет callback-функцию к каждому элементу (эквивалент array_walk для ассоциативных массивов).
     *
     * Применяет пользовательскую callback-функцию к каждому элементу массива,
     * сохраняя ключи. Callback получает и значение, и ключ в качестве параметров.
     * Возвращает новый CoverArray с результатами.
     *
     * @param callable $callback Callback function to apply, must be callback(mixed $value, mixed $key): mixed.
     *                           Callback-функция для применения, должна быть callback(mixed $value, mixed $key): mixed.
     * @return static New CoverArray instance with callback applied to each element.
     *                Новый экземпляр CoverArray с примененным callback к каждому элементу.
     * @see CoverArray::map()
     * @see array_walk()
     */
    final public function each(callable $callback): static
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            $result[$key] = $callback($value, $key);
        }

        return new static($result);
    }

    /**
     * Recursively applies a callback function to all elements (array_walk_recursive equivalent).
     *
     * Applies a user-defined callback function to every element in a multidimensional array recursively.
     * The callback function receives both value and key as parameters.
     *
     *
     * Рекурсивно применяет callback-функцию ко всем элементам (эквивалент array_walk_recursive).
     *
     * Рекурсивно применяет пользовательскую callback-функцию к каждому элементу в многомерном массиве.
     * Callback-функция получает и значение, и ключ в качестве параметров.
     *
     * @param callable $callback Callback function to apply, must be callback(mixed $value, mixed $key): mixed.
     *                           Callback-функция для применения, должна быть callback(mixed $value, mixed $key): mixed.
     * @return static New CoverArray instance with callback applied recursively to all elements.
     *                Новый экземпляр CoverArray с рекурсивно примененным callback ко всем элементам.
     * @see array_walk_recursive()
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
     * Checks if a value exists in an array (in_array equivalent).
     *
     * Checks if a value exists in the array using loose comparison by default.
     * Can use strict comparison if the strict parameter is set to true.
     *
     *
     * Проверяет, содержится ли значение в массиве (эквивалент in_array).
     *
     * Проверяет, существует ли значение в массиве, используя нестрогое сравнение по умолчанию.
     * Может использовать строгое сравнение, если параметр strict установлен в true.
     *
     * @param mixed $needle The value to search for.
     *                      Искомое значение.
     * @param bool $strict If true, uses strict comparison (===).
     *                     Если true, использует строгое сравнение (===).
     * @return bool True if needle is found in the array, false otherwise.
     *              Возвращает true, если значение найдено в массиве, иначе false.
     * @see in_array()
     */
    final public function in(mixed $needle, bool $strict = false): bool
    {
        return in_array($needle, $this->data, $strict);
    }

    /**
     * Returns an array with elements in reverse order (array_reverse equivalent).
     *
     * Returns a new array with elements in reverse order.
     * Optionally preserves the original keys.
     *
     *
     * Возвращает массив с элементами в обратном порядке (эквивалент array_reverse).
     *
     * Возвращает новый массив с элементами в обратном порядке.
     * Опционально сохраняет оригинальные ключи.
     *
     * @param bool $preserve_keys Whether to preserve keys (true) or re-index (false).
     *                            Сохранять ключи (true) или переиндексировать (false).
     * @return static New CoverArray instance with reversed elements.
     *                Новый экземпляр CoverArray с элементами в обратном порядке.
     * @see array_reverse()
     */
    final public function reverse(bool $preserve_keys = false): static
    {
        return new static(
            array_reverse($this->data, $preserve_keys)
        );
    }

    /**
     * Returns all the values of an array (array_values equivalent).
     *
     * Returns all the values from the array and indexes the array numerically.
     * This function resets the array's internal pointer.
     *
     *
     * Возвращает все значения массива (эквивалент array_values).
     *
     * Возвращает все значения из массива и индексирует массив численно.
     * Эта функция сбрасывает внутренний указатель массива.
     *
     * @return static New CoverArray instance containing only the values, numerically indexed.
     *                Новый экземпляр CoverArray, содержащий только значения с числовой индексацией.
     * @see array_values()
     */
    final public function values(): static
    {
        return new static(
            array_values($this->data)
        );
    }

    /**
     * Removes duplicate values from an array (array_unique equivalent).
     *
     * Returns a new array without duplicate values.
     * The comparison method can be controlled with the flags parameter.
     *
     *
     * Удаляет повторяющиеся значения из массива (эквивалент array_unique).
     *
     * Возвращает новый массив без повторяющихся значений.
     * Метод сравнения может контролироваться параметром flags.
     *
     * @param int $flags Sorting behavior flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING).
     *                   Флаги поведения сортировки (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING).
     * @return static New CoverArray instance with unique values.
     *                Новый экземпляр CoverArray с уникальными значениями.
     * @see array_unique()
     */
    final public function unique(int $flags = SORT_STRING): static
    {
        return new static(
            array_unique($this->data, $flags)
        );
    }

    /**
     * Prepends one or more elements to the beginning of an array (array_unshift equivalent).
     *
     * Adds one or more elements to the beginning of the array and returns the instance.
     * Numerical keys will be re-indexed starting from zero.
     * String keys will be preserved.
     *
     *
     * Добавляет один или несколько элементов в начало массива (эквивалент array_unshift).
     *
     * Добавляет один или несколько элементов в начало массива и возвращает экземпляр.
     * Числовые ключи будут переиндексированы, начиная с нуля.
     * Строковые ключи будут сохранены.
     *
     * @param mixed ...$args Elements to prepend to the array.
     *                       Элементы для добавления в начало массива.
     * @return static Current CoverArray instance with prepended elements.
     *                Текущий экземпляр CoverArray с добавленными в начало элементами.
     * @see array_unshift()
     */
    final public function prepend(mixed ...$args): static
    {
        foreach ($args as $value) {
            array_unshift($this->data, $this->array2cover($value));
        }

        return $this;
    }

    /**
     * Prepends one or more elements to the beginning of an array (prepend() alias).
     *
     * Alias for the prepend() method. Adds elements to the beginning of the array.
     * This method provides compatibility with PHP's array_unshift function name.
     *
     *
     * Добавляет один или несколько элементов в начало массива (псевдоним prepend()).
     *
     * Псевдоним метода prepend(). Добавляет элементы в начало массива.
     * Этот метод обеспечивает совместимость с именем функции PHP array_unshift.
     *
     * @param mixed ...$args Elements to prepend to the array.
     *                       Элементы для добавления в начало массива.
     * @return static Current CoverArray instance with prepended elements.
     *                Текущий экземпляр CoverArray с добавленными в начало элементами.
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    final public function unshift(mixed ...$args): static
    {
        return $this->prepend(...$args);
    }

    /**
     * Appends one or more elements to the end of an array (array_push equivalent).
     *
     * Adds one or more elements to the end of the array and returns the instance.
     *
     *
     * Добавляет один или несколько элементов в конец массива (эквивалент array_push).
     *
     * Добавляет один или несколько элементов в конец массива и возвращает экземпляр.
     *
     * @param mixed ...$args Elements to append to the array.
     *                       Элементы для добавления в конец массива.
     * @return static Current CoverArray instance with appended elements.
     *                Текущий экземпляр CoverArray с добавленными в конец элементами.
     * @see array_push()
     */
    final public function append(mixed ...$args): static
    {
        foreach ($args as $value) {
            $this->data[] = $this->array2cover($value);
        }

        return $this;
    }

    /**
     * Appends one or more elements to the end of an array (append() alias).
     *
     * Alias for the append() method. Adds elements to the end of the array.
     * This method provides compatibility with PHP's array_push function name.
     *
     *
     * Добавляет один или несколько элементов в конец массива (псевдоним append()).
     *
     * Псевдоним метода append(). Добавляет элементы в конец массива.
     * Этот метод обеспечивает совместимость с именем функции PHP array_push.
     *
     * @param mixed ...$args Elements to append to the array.
     *                       Элементы для добавления в конец массива.
     * @return static Current CoverArray instance with appended elements.
     *                Текущий экземпляр CoverArray с добавленными в конец элементами.
     * @see CoverArray::append()
     * @see array_push()
     */
    final public function push(mixed ...$args): static
    {
        return $this->append(...$args);
    }

    /**
     * Returns the first element of the array (array_first equivalent).
     *
     * Returns the value of the first element in the array without affecting
     * the internal array pointer. Returns null if the array is empty.
     *
     *
     * Получает первое значение массива (эквивалент array_first).
     *
     * Возвращает значение первого элемента массива, не затрагивая внутренний указатель массива.
     * Возвращает null, если массив пуст.
     *
     * @return mixed First element value or null if array is empty.
     *               Значение первого элемента или null, если массив пуст.
     */
    final public function getFirst(): mixed
    {
        return $this->count() > 0 ? $this->data[array_key_first($this->data)] : null;
    }

    /**
     * Returns the last element of the array (array_last equivalent).
     *
     * Returns the value of the last element in the array without affecting
     * the internal array pointer. Returns null if the array is empty.
     *
     *
     * Получает последнее значение массива (эквивалент array_last).
     *
     * Возвращает значение последнего элемента массива, не затрагивая внутренний указатель массива.
     * Возвращает null, если массив пуст.
     *
     * @return mixed Last element value or null if array is empty.
     *               Значение последнего элемента или null, если массив пуст.
     */
    final public function getLast(): mixed
    {
        return $this->count() > 0 ? $this->data[array_key_last($this->data)] : null;
    }

    /**
     * Converts arrays to CoverArray instances recursively.
     *
     * Helper method that converts arrays to CoverArray instances recursively.
     * Used internally when setting data to ensure nested arrays become CoverArray objects.
     * Callable arrays are not converted.
     *
     *
     * Преобразует массивы в экземпляры CoverArray рекурсивно.
     *
     * Вспомогательный метод, который преобразует массивы в экземпляры CoverArray рекурсивно.
     * Используется внутри при установке данных, чтобы гарантировать, что вложенные массивы
     * становятся объектами CoverArray. Callable-массивы не преобразуются.
     *
     * @param mixed $value Value to potentially convert to CoverArray.
     *                     Значение для потенциального преобразования в CoverArray.
     * @param int $depth Current recursion depth.
     *                   Текущая глубина рекурсии.
     * @param int $maxDepth Maximum allowed recursion depth.
     *                      Максимально допустимая глубина рекурсии.
     * @return mixed|static Original value or CoverArray instance.
     *                      Исходное значение или экземпляр CoverArray.
     * @throws RuntimeException If maximum recursion depth is exceeded.
     *                          Если превышена максимальная глубина рекурсии.
     */
    final protected function array2cover(mixed $value, int $depth = 0, int $maxDepth = 512): mixed
    {
        if ($depth > $maxDepth) {
            throw new RuntimeException('Maximum recursion depth exceeded');
        }

        if ($value instanceof self) {
            return $value;
        }

        if (!is_array($value)) {
            return $value;
        }

        // Do not convert callable-arrays
        if (is_callable($value)) {
            return $value;
        }

        $result = new static();
        foreach ($value as $k => $v) {
            $result[$k] = $this->array2cover($v, $depth + 1, $maxDepth);
        }

        return $result;
    }

    /**
     * Converts CoverArray or array to plain PHP array.
     *
     * Helper method that converts CoverArray instances to plain PHP arrays
     * and leaves regular arrays unchanged. Used for interoperability with
     * PHP's native array functions.
     *
     *
     * Преобразует CoverArray или массив в обычный массив PHP.
     *
     * Вспомогательный метод, который преобразует экземпляры CoverArray в обычные массивы PHP
     * и оставляет обычные массивы неизменными. Используется для взаимодействия с
     * нативными функциями массивов PHP.
     *
     * @param CoverArray|array $data Data to convert to plain array.
     *                               Данные для преобразования в обычный массив.
     * @return array Plain PHP array representation.
     *               Представление в виде обычного массива PHP.
     */
    final protected static function convertToPlainArray(CoverArray|array $data): array
    {
        return $data instanceof self ? $data->getDataAsArray() : $data;
    }
}