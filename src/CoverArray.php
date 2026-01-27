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
use Stringable;
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
 * @link https://github.com/Vasiliy-Makogon/PHP-Collection
 */
class CoverArray implements IteratorAggregate, Countable, ArrayAccess, JsonSerializable, Stringable
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
     * @see CoverArray::fromArray()
     */
    public function __construct(?iterable $data = null)
    {
        $this->setData($data);
    }

    /**
     * Checks if the array is empty.
     * Returns true if the array contains no elements, false otherwise.
     *
     *
     * Проверяет, является ли массив пустым.
     * Возвращает true, если массив не содержит элементов, иначе false.
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
    public function __toString(): string
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
     * Merges the provided iterable into the existing data, overwriting values
     * for keys that already exist. Nested arrays are converted to CoverArray
     * instances recursively. Keys not present in the provided iterable remain unchanged.
     *
     *
     * Устанавливает внутренние данные для CoverArray.
     *
     * Сливает предоставленный итерируемый объект с существующими данными, перезаписывая
     * значения для уже существующих ключей. Вложенные массивы преобразуются в экземпляры
     * CoverArray рекурсивно. Ключи, отсутствующие в предоставленном объекте, остаются без изменений.
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
     */
    final public function copy(): static
    {
        return clone $this;
    }

    /**
     * Implements the IteratorAggregate interface.
     * Returns an iterator for the array, allowing foreach loops to work.
     *
     *
     * Реализует интерфейс IteratorAggregate.
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
     * Returns the value at the specified offset, or null if the offset doesn't exist.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetGet.
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
     * Checks whether the specified offset exists in the array.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetExists.
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
     * Unsets the value at the specified offset if it exists.
     *
     *
     * Реализует метод интерфейса ArrayAccess::offsetUnset.
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
        return $this->data;
    }

    /**
     * Unserializes the object from serialized data.
     * Restores the object state from serialized data array.
     *
     *
     * Десериализует объект из сериализованных данных.
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
        foreach ($this->data as $key => $value) {
            $data[$key] = $value instanceof self ? $value->{__FUNCTION__}() : $value;
        }

        return $data;
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
        return $this->data;
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
     * Returns data by keys of the current object using dot notation.
     *
     * Allows accessing nested array elements using dot notation (e.g., 'user.profile.name').
     * Returns the value at the specified path or processes it through a callback function if provided.
     * If any segment doesn't exist and no callback is provided, returns null.
     *
     * The callback function receives the found value as its only parameter and can transform it.
     * This allows for elegant data transformation pipelines and handling of missing data.
     *
     *
     * Возвращает данные по ключам текущего объекта с использованием точечной нотации.
     *
     * Позволяет получать доступ к вложенным элементам массива с использованием точечной нотации
     * (например, 'user.profile.name'). Возвращает значение по указанному пути или обрабатывает его
     * через callback-функцию, если она предоставлена.
     * Если любой сегмент не существует и callback не предоставлен, возвращает null.
     *
     * Callback-функция получает найденное значение в качестве единственного параметра и может преобразовать его.
     * Это позволяет создавать элегантные конвейеры преобразования данных и обрабатывать отсутствующие данные.
     *
     * @param string $path Dot-notation path to the desired value.
     *                     Путь в точечной нотации к желаемому значению.
     * @param callable|null $callback Optional callback function to process the found value.
     *                                Callback signature: `function(mixed $value): mixed`
     *                                Optionalный callback для обработки найденного значения.
     *                                Сигнатура: `function(mixed $value): mixed`
     * @return mixed The value at the specified path, callback result if provided, or null if path doesn't exist.
     *               Значение по указанному пути, результат callback если предоставлен, или null если путь не существует.
     * @throws InvalidArgumentException If the path is empty.
     *                                  Если путь пуст.
     *
     * @example
     *  // Basic usage
     *  $data->get('user.profile.name'); // Returns the name or null
     *
     *  // With callback for transformation
     *  $response = CoverArray::fromJson($apiResponse)
     *      ->get('data.users', function (mixed $users): array {
     *          if ($users === null) {
     *              return [];
     *          }
     *
     *          /** @var CoverArray $users *\/
     *          return $users->filter(fn($u) => $u['active'] == '1')
     *              ->column('name')
     *              ->getDataAsArray();
     *      });
     *
     *  // With callback for missing data
     *  $data->get('non.existent.path', function($value) {
     *      return $value ?? 'default value';
     *  });
     */
    final public function get(string $path, ?callable $callback = null): mixed
    {
        if ($path === '') {
            throw new InvalidArgumentException('Path cannot be empty');
        }

        [0 => $key, 1 => $other] = array_pad(explode('.', $path, 2), 2, null);

        $actual_data = $this->data[$key] ?? null;

        // The keys in the chain of succession have run out.
        if ($other === null) {
            return is_callable($callback) ? $callback($actual_data) : $actual_data;
        }

        if (!($actual_data instanceof self) || !method_exists($actual_data, 'get')) {
            return is_callable($callback) ? $callback($actual_data) : null;
        }

        return $this->data[$key]->get($other, $callback);
    }

    /**
     * Converts the CoverArray to a JSON string.
     * Serializes the CoverArray data to a JSON string representation.
     *
     *
     * Преобразует CoverArray в строку JSON.
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

    /*******************************************************************************************************************
     * Start implementing aliases for PHP functions
     ******************************************************************************************************************/

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
                static::convertToPlain($keys),
                static::convertToPlain($values)
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
                [self::class, 'convertToPlain'],
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
                [self::class, 'convertToPlain'],
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
                [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                static::convertToPlain($keys),
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
    final public function first(): mixed
    {
        if (!function_exists('array_first')) {
            return $this->count() > 0 ? $this->data[array_key_first($this->data)] : null;
        }

        return array_first($this->data);
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$key_compare_func]
            ))
        );
    }

    /**
     * Checks if the array is a list (array_is_list equivalent).
     *
     * Returns true if the array keys are sequential integers starting from 0,
     * and there are no gaps in the sequence. An empty array is considered a list.
     * This method ensures compatibility with PHP 8.1's array_is_list function
     * while providing a polyfill for older PHP versions.
     *
     *
     * Проверяет, является ли массив списком (эквивалент array_is_list).
     *
     * Возвращает true, если ключи массива являются последовательными целыми числами,
     * начинающимися с 0, и в последовательности нет пропусков. Пустой массив считается списком.
     * Этот метод обеспечивает совместимость с функцией array_is_list PHP 8.1,
     * предоставляя полифил для более старых версий PHP.
     *
     * @return bool True if the array is a list, false otherwise.
     *              Возвращает true, если массив является списком, иначе false.
     * @see array_is_list()
     */
    final public function isList(): bool
    {
        if (!function_exists('array_is_list')) {
            if ($this->data === []) {
                return true;
            }

            $keys = array_keys($this->data);
            $i = 0;
            foreach ($keys as $key) {
                // Для списка ключ должен быть равен i, и если это строка,
                // она должна быть точным представлением числа i
                if ($key !== $i) {
                    return false;
                }
                $i++;
            }
            return true;
        }

        return array_is_list($this->data);
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
    final public function last(): mixed
    {
        if (!function_exists('array_last')) {
            return $this->count() > 0 ? $this->data[array_key_last($this->data)] : null;
        }

        return array_last($this->data);
    }

    /**
     * Applies a callback function to the elements and returns a new instance (array_map equivalent).
     *
     * This method is equivalent to PHP's `array_map()` function with these key characteristics:
     * 1. Returns a NEW CoverArray instance (immutable operation)
     * 2. Callback receives only VALUES (not keys) unless using null callback
     * 3. Supports multiple input arrays for parallel processing
     * 4. Numeric keys are re-indexed (0, 1, 2...), associative keys may be lost
     *
     * DIFFERENCES from other methods:
     * - Unlike `each()`, which receives both value AND key, `map()` callback receives only values (unless null callback)
     * - Unlike `walk()`, which modifies the current instance, `map()` returns a new instance
     * - Unlike `eachRecursive()` and `walkRecursive()`, which process nested arrays, `map()` works only at the first level
     * - Unlike `each()` and `walk()`, which preserve original keys, `map()` re-indexes numeric keys
     * - Unlike all other methods in this group, `map()` can process multiple arrays simultaneously
     *
     * KEY CHARACTERISTICS:
     * - Immutable operation (returns new CoverArray)
     * - Numeric keys are re-indexed, associative keys may be lost
     * - Supports processing multiple arrays in parallel
     * - Works only at the first nesting level
     *
     * Use `map()` when:
     * - You need to process multiple arrays in parallel
     * - Keys are not important (or you want numeric re-indexing)
     * - You want array_map() behavior with object syntax
     * - You're working only with flat arrays (no nested structures)
     *
     * Use `each()`, `walk()`, `eachRecursive()`, or `walkRecursive()` when:
     * - You need to preserve associative keys (`each()` or `walk()`)
     * - You need to process nested arrays (`eachRecursive()` or `walkRecursive()`)
     * - You need to modify the array in-place (`walk()` or `walkRecursive()`)
     * - You need both value AND key in the callback (`each()` or `walk()`)
     *
     *
     * Применяет callback-функцию к элементам и возвращает новый экземпляр (эквивалент array_map).
     *
     * Этот метод эквивалентен функции PHP `array_map()` с ключевыми особенностями:
     * 1. Возвращает НОВЫЙ экземпляр CoverArray (иммутабельная операция)
     * 2. Callback получает только ЗНАЧЕНИЯ (не ключи), если только не используется null callback
     * 3. Поддерживает несколько входных массивов для параллельной обработки
     * 4. Числовые ключи переиндексируются (0, 1, 2...), ассоциативные ключи могут быть потеряны
     *
     * ОТЛИЧИЯ от других методов:
     * - В отличие от `each()`, который получает и значение, И ключ, `map()` callback получает только значения (кроме null callback)
     * - В отличие от `walk()`, который изменяет текущий экземпляр, `map()` возвращает новый экземпляр
     * - В отличие от `eachRecursive()` и `walkRecursive()`, которые обрабатывают вложенные массивы, `map()` работает только на первом уровне
     * - В отличие от `each()` и `walk()`, которые сохраняют оригинальные ключи, `map()` переиндексирует числовые ключи
     * - В отличие от всех других методов в этой группе, `map()` может обрабатывать несколько массивов одновременно
     *
     * КЛЮЧЕВЫЕ ХАРАКТЕРИСТИКИ:
     * - Иммутабельная операция (возвращает новый CoverArray)
     * - Числовые ключи переиндексируются, ассоциативные ключи могут быть потеряны
     * - Поддерживает параллельную обработку нескольких массивов
     * - Работает только на первом уровне вложенности
     *
     * Используйте `map()`, когда:
     * - Нужно обрабатывать несколько массивов параллельно
     * - Ключи не важны (или нужна числовая переиндексация)
     * - Нужно поведение array_map() с объектным синтаксисом
     * - Работаете только с плоскими массивами (без вложенных структур)
     *
     * Используйте `each()`, `walk()`, `eachRecursive()` или `walkRecursive()`, когда:
     * - Нужно сохранить ассоциативные ключи (`each()` или `walk()`)
     * - Нужно обрабатывать вложенные массивы (`eachRecursive()` или `walkRecursive()`)
     * - Нужно изменить массив на месте (`walk()` или `walkRecursive()`)
     * - Нужны и значение, И ключ в callback (`each()` или `walk()`)
     *
     * @param callable|null $callback Callback function to apply. If null, creates an array of arrays/tuples.
     *                                Callback signature depends on number of arrays:
     *                                - 1 array: `function(mixed $value): mixed`
     *                                - 2 arrays: `function(mixed $value1, mixed $value2): mixed`
     *                                - etc.
     *                                Callback-функция для применения. Если null, создаёт массив массивов/кортежей.
     *                                Сигнатура callback зависит от количества массивов:
     *                                - 1 массив: `function(mixed $value): mixed`
     *                                - 2 массива: `function(mixed $value1, mixed $value2): mixed`
     *                                - и т.д.
     * @param CoverArray|array ...$arrays Additional arrays to process in parallel.
     *                                    Дополнительные массивы для параллельной обработки.
     * @return static New CoverArray instance with transformed values.
     *                Новый экземпляр CoverArray с преобразованными значениями.
     *
     * @example
     * $arr = CoverArray::fromArray(['a' => 1, 'b' => 2, 'c' => 3]);
     * $result = $arr->map(fn($x) => $x * 2);
     * // Result: [2, 4, 6] (keys 0, 1, 2 - original keys lost)
     *
     * @see array_map()
     * @see CoverArray::each() For mapping with key preservation
     *                         Для преобразования с сохранением ключей
     * @see CoverArray::walk() For in-place modification with key preservation
     *                         Для изменения на месте с сохранением ключей
     * @see CoverArray::eachRecursive() For recursive immutable transformation
     *                                  Для рекурсивного иммутабельного преобразования
     * @see CoverArray::walkRecursive() For recursive in-place modification
     *                                  Для рекурсивного изменения на месте
     */
    final public function map(null|callable $callback, CoverArray|array ...$arrays): static
    {
        return new static(
            array_map(
                $callback,
                ...array_merge([$this->data],
                    array_map(
                        [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
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
                    [self::class, 'convertToPlain'],
                    $arrays
                )
            )
        );
    }

    // array_multisort now is empty

    /**
     * Pad array to the specified length with a value (array_pad equivalent).
     *
     * Returns a new CoverArray padded to the specified length with the given value.
     * If length is positive, the array is padded on the right; if negative, on the left.
     * If the absolute value of length is less than or equal to the length of the array,
     * the array is returned unchanged.
     *
     *
     * Дополняет массив до указанной длины значением (эквивалент array_pad).
     *
     * Возвращает новый CoverArray, дополненный до указанной длины заданным значением.
     * Если длина положительная, массив дополняется справа; если отрицательная - слева.
     * Если абсолютное значение длины меньше или равно длине массива,
     * массив возвращается без изменений.
     *
     * @param int $length The new size of the array.
     *                    Новый размер массива.
     * @param mixed $value Value to pad if the array needs to be expanded.
     *                     Значение для дополнения, если массив нужно расширить.
     * @return static New CoverArray instance padded to the given length.
     *                Новый экземпляр CoverArray, дополненный до заданной длины.
     * @see array_pad()
     */
    final public function pad(int $length, mixed $value): static
    {
        return new static(
            array_pad($this->data, $length, $value)
        );
    }

    /**
     * Pop the element off the end of the array (array_pop equivalent).
     *
     * Removes and returns the last element of the current CoverArray,
     * shortening the array by one element. Returns null if the array is empty.
     *
     * Note: This method modifies the current CoverArray instance.
     *
     *
     * Извлекает последний элемент массива (эквивалент array_pop).
     *
     * Удаляет и возвращает последний элемент текущего CoverArray,
     * уменьшая массив на один элемент. Возвращает null, если массив пуст.
     *
     * Примечание: Этот метод изменяет текущий экземпляр CoverArray.
     *
     * @return mixed The last element of the array or null if empty.
     *               Последний элемент массива или null, если массив пуст.
     * @see array_pop()
     */
    final public function pop(): mixed
    {
        return array_pop($this->data);
    }

    /**
     * Calculate the product of values in an array (array_product equivalent).
     *
     * Returns the product of all values in the CoverArray as an integer or float.
     * If the array is empty, returns 0 (matching array_product behavior).
     * Note: Non-numeric values are converted to numbers (0 for non-numeric strings).
     *
     * Important: This method uses the @ operator to suppress E_WARNING errors
     * that are generated by PHP's array_product() function starting from PHP 8.3
     * when encountering non-scalar values (arrays, objects, resources, callables).
     * The @ operator ensures consistent behavior across all PHP versions and
     * matches the behavior of array_product() when called with error suppression.
     *
     *
     * Вычисляет произведение значений массива (эквивалент array_product).
     *
     * Возвращает произведение всех значений в CoverArray в виде целого числа или числа с плавающей точкой.
     * Если массив пуст, возвращает 0 (соответствует поведению array_product).
     * Примечание: Нечисловые значения преобразуются в числа (0 для нечисловых строк).
     *
     * Важно: Этот метод использует оператор @ для подавления ошибок E_WARNING,
     * которые генерируются функцией array_product() PHP начиная с версии 8.3
     * при обнаружении нескалярных значений (массивов, объектов, ресурсов, callable).
     * Оператор @ обеспечивает согласованное поведение во всех версиях PHP и
     * соответствует поведению array_product() при вызове с подавлением ошибок.
     *
     * @return int|float The product of array values as an integer or float.
     *                   Произведение значений массива в виде целого числа или числа с плавающей точкой.
     * @see array_product()
     */
    final public function product(): int|float
    {
        return @array_product($this->data);
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
     * @see CoverArray::push()
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
     * Picks one or more random keys from the array (array_rand equivalent).
     *
     * Returns a random key (or keys) from the current CoverArray.
     * If only one entry is requested, returns a single key as a scalar value.
     * If multiple entries are requested, returns a CoverArray containing the random keys.
     *
     * Note: This function does not modify the original array.
     *
     *
     * Выбирает один или несколько случайных ключей из массива (эквивалент array_rand).
     *
     * Возвращает случайный ключ (или ключи) из текущего CoverArray.
     * Если запрошена только одна запись, возвращает отдельный ключ как скалярное значение.
     * Если запрошено несколько записей, возвращает CoverArray, содержащий случайные ключи.
     *
     * Примечание: Эта функция не изменяет исходный массив.
     *
     * @param int $num Specifies how many entries should be picked.
     *                 Определяет, сколько записей должно быть выбрано.
     * @return int|string|CoverArray Single key if $num is 1, otherwise CoverArray with random keys.
     *                               Отдельный ключ, если $num равен 1, иначе CoverArray со случайными ключами.
     * @see array_rand()
     */
    final public function rand(int $num = 1): int|string|CoverArray
    {
        return $this->array2cover(array_rand($this->data, $num));
    }

    /**
     * Reduces the array to a single value using a callback function (array_reduce equivalent).
     *
     * Iteratively reduces the array to a single value using a callback function.
     *
     * Сводит массив к единственному значению через callback-функцию (эквивалент array_reduce).
     *
     * Итеративно сводит массив к единственному значению через callback-функцию.
     *
     * @param callable $callback The callback function.
     *                           Callback-функция.
     * @param mixed $initial Initial value to carry.
     *                       Начальное значение для передачи.
     * @return mixed The resulting value.
     *               Результирующее значение.
     * @see array_reduce()
     */
    final public function reduce(callable $callback, mixed $initial = null): mixed
    {
        // TODO: Implement array_reduce equivalent
        return array_reduce($this->data, $callback, $initial);
    }

    /**
     * Replaces elements from passed arrays into the current array (array_replace equivalent).
     *
     * Replaces the values of the current array with values from following arrays.
     *
     * Заменяет элементы массива элементами других массивов (эквивалент array_replace).
     *
     * @param CoverArray|array ...$replacement Arrays from which elements will be extracted.
     *                                          Массивы, из которых будут извлекаться элементы.
     * @return static New CoverArray instance with replaced elements.
     *                Новый экземпляр CoverArray с замененными элементами.
     * @see array_replace()
     */
    final public function replace(CoverArray|array ...$replacement): static
    {
        // TODO: Implement array_replace equivalent
        return new static(
            array_replace(
                $this->data,
                ...array_map(
                    [self::class, 'convertToPlain'],
                    $replacement
                )
            )
        );
    }

    /**
     * Replaces elements recursively (array_replace_recursive equivalent).
     *
     * Recursively replaces elements from passed arrays into the current array.
     *
     * Рекурсивно заменяет элементы первого массива элементами других массивов (эквивалент array_replace_recursive).
     *
     * @param CoverArray|array ...$replacement Arrays from which elements will be extracted.
     *                                          Массивы, из которых будут извлекаться элементы.
     * @return static New CoverArray instance with recursively replaced elements.
     *                Новый экземпляр CoverArray с рекурсивно замененными элементами.
     * @see array_replace_recursive()
     */
    final public function replaceRecursive(CoverArray|array ...$replacement): static
    {
        // TODO: Implement array_replace_recursive equivalent
        return new static(
            array_replace_recursive(
                $this->getDataAsArray(),
                ...array_map(
                    [self::class, 'convertToPlain'],
                    $replacement
                )
            )
        );
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
     * Searches the array for a given value and returns the first corresponding key (array_search equivalent).
     *
     * Searches the array for a given value and returns the first corresponding key if successful.
     *
     * Ищет значение в массиве и возвращает ключ первого найденного элемента (эквивалент array_search).
     *
     * @param mixed $needle The value to search for.
     *                      Искомое значение.
     * @param bool $strict If true, uses strict comparison (===).
     *                     Если true, использует строгое сравнение (===).
     * @return int|string|false The key for needle if found, false otherwise.
     *                          Ключ найденного значения или false если не найдено.
     * @see array_search()
     */
    final public function search(mixed $needle, bool $strict = false): int|string|false
    {
        // TODO: Implement array_search equivalent
        return array_search($needle, $this->data, $strict);
    }

    /**
     * Shifts the first element off the array (array_shift equivalent).
     *
     * Shifts the first value of the array off and returns it.
     *
     * Извлекает первый элемент массива (эквивалент array_shift).
     *
     * @return mixed The shifted value or null if array is empty.
     *               Извлеченное значение или null если массив пуст.
     * @see array_shift()
     */
    final public function shift(): mixed
    {
        // TODO: Implement array_shift equivalent
        return array_shift($this->data);
    }

    /**
     * Extracts a slice of the array (array_slice equivalent).
     *
     * Extracts a slice of the array.
     *
     * Выбирает срез массива (эквивалент array_slice).
     *
     * @param int $offset Starting offset.
     *                    Начальное смещение.
     * @param int|null $length Length of the slice.
     *                         Длина среза.
     * @param bool $preserve_keys Whether to preserve keys.
     *                            Сохранять ли ключи.
     * @return static New CoverArray instance containing the slice.
     *                Новый экземпляр CoverArray, содержащий срез.
     * @see array_slice()
     */
    final public function slice(int $offset, ?int $length = null, bool $preserve_keys = false): static
    {
        // TODO: Implement array_slice equivalent
        return new static(
            array_slice($this->data, $offset, $length, $preserve_keys)
        );
    }

    /**
     * Removes a portion of the array and replaces it with something else (array_splice equivalent).
     *
     * Removes a portion of the array and replaces it with something else.
     *
     * Удаляет часть массива и заменяет её новыми элементами (эквивалент array_splice).
     *
     * @param int $offset Starting position.
     *                    Начальная позиция.
     * @param int|null $length Number of elements to remove.
     *                         Количество элементов для удаления.
     * @param mixed $replacement Elements to insert.
     *                           Элементы для вставки.
     * @return static New CoverArray instance containing the removed elements.
     *                Новый экземпляр CoverArray, содержащий удаленные элементы.
     * @see array_splice()
     */
    final public function splice(int $offset, ?int $length = null, mixed $replacement = []): static
    {
        // TODO: Implement array_splice equivalent
        $removed = array_splice($this->data, $offset, $length, $replacement);
        return new static($removed);
    }

    /**
     * Calculates the sum of values in the array (array_sum equivalent).
     *
     * Calculates the sum of values in the array.
     *
     * Вычисляет сумму значений массива (эквивалент array_sum).
     *
     * @return int|float Sum of values.
     *                   Сумма значений.
     * @see array_sum()
     */
    final public function sum(): int|float
    {
        // TODO: Implement array_sum equivalent
        return array_sum($this->data);
    }

    /**
     * Computes the difference of arrays using a callback for data comparison (array_udiff equivalent).
     *
     * Computes the difference of arrays using a callback function for data comparison.
     *
     * Вычисляет расхождение массивов, используя callback-функцию для сравнения (эквивалент array_udiff).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_udiff()
     */
    final public function udiff(callable $value_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_udiff', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func]
            ))
        );
    }

    /**
     * Computes the difference of arrays with additional index check using callback for data comparison (array_udiff_assoc equivalent).
     *
     * Computes the difference of arrays with additional index check using callback for data comparison.
     *
     * Вычисляет расхождение в массивах с дополнительной проверкой индексов, используя callback для сравнения значений (эквивалент array_udiff_assoc).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_udiff_assoc()
     */
    final public function udiffAssoc(callable $value_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_udiff_assoc', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func]
            ))
        );
    }

    /**
     * Computes the difference of arrays with additional index check using callbacks for both data and index comparison (array_udiff_uassoc equivalent).
     *
     * Computes the difference of arrays with additional index check using callbacks for both data and index comparison.
     *
     * Вычисляет расхождение в массивах с дополнительной проверкой индексов, используя callback для сравнения значений и индексов (эквивалент array_udiff_uassoc).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the difference.
     *                Новый экземпляр CoverArray, содержащий разницу.
     * @see array_udiff_uassoc()
     */
    final public function udiffUassoc(
        callable $value_compare_func,
        callable $key_compare_func,
        CoverArray|array ...$arrays
    ): static {
        return new static(
            call_user_func_array('array_udiff_uassoc', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func],
                [$key_compare_func]
            ))
        );
    }

    /**
     * Computes the intersection of arrays using callback for data comparison (array_uintersect equivalent).
     *
     * Computes the intersection of arrays using a callback function for data comparison.
     *
     * Вычисляет пересечение массивов, используя callback для сравнения значений (эквивалент array_uintersect).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_uintersect()
     */
    final public function uintersect(callable $value_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_uintersect', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func]
            ))
        );
    }

    /**
     * Computes the intersection of arrays with additional index check using callback for data comparison (array_uintersect_assoc equivalent).
     *
     * Computes the intersection of arrays with additional index check using callback for data comparison.
     *
     * Вычисляет пересечение массивов с дополнительной проверкой индексов, используя callback для сравнения значений (эквивалент array_uintersect_assoc).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_uintersect_assoc()
     */
    final public function uintersectAssoc(callable $value_compare_func, CoverArray|array ...$arrays): static
    {
        return new static(
            call_user_func_array('array_uintersect_assoc', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func]
            ))
        );
    }

    /**
     * Computes the intersection of arrays with additional index check using callbacks for both data and index comparison (array_uintersect_uassoc equivalent).
     *
     * Computes the intersection of arrays with additional index check using callbacks for both data and index comparison.
     *
     * Вычисляет пересечение массивов с дополнительной проверкой индекса, используя callback для сравнения индексов и значений (эквивалент array_uintersect_uassoc).
     *
     * @param callable $value_compare_func Callback function for value comparison.
     *                                     Callback-функция для сравнения значений.
     * @param callable $key_compare_func Callback function for key comparison.
     *                                   Callback-функция для сравнения ключей.
     * @param CoverArray|array ...$arrays Arrays to compare against.
     *                                    Массивы для сравнения.
     * @return static New CoverArray instance containing the intersection.
     *                Новый экземпляр CoverArray, содержащий пересечение.
     * @see array_uintersect_uassoc()
     */
    final public function uintersectUassoc(
        callable $value_compare_func,
        callable $key_compare_func,
        CoverArray|array ...$arrays
    ): static {
        return new static(
            call_user_func_array('array_uintersect_uassoc', array_merge(
                [$this->data],
                array_map(
                    [self::class, 'convertToPlain'],
                    $arrays
                ),
                [$value_compare_func],
                [$key_compare_func]
            ))
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
     * @see CoverArray::unshift()
     */
    final public function prepend(mixed ...$args): static
    {
        if (empty($args)) {
            return $this;
        }

        $args = array_map([$this, 'array2cover'], $args);
        array_unshift($this->data, ...$args);

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
     * Applies a callback function to each element in-place (mutates the instance).
     *
     * This method is equivalent to PHP's `array_walk()` function with these key characteristics:
     * 1. Modifies the CURRENT CoverArray instance (mutable operation)
     * 2. Callback receives value BY REFERENCE (can modify directly)
     * 3. Preserves all original keys (associative and numeric)
     * 4. Automatically converts arrays to CoverArray instances when set
     *
     * DIFFERENCES from other methods:
     * - Unlike `each()`, which returns a new instance, `walk()` modifies the current instance
     * - Unlike `map()`, which re-indexes numeric keys, `walk()` preserves all original keys
     * - Unlike `walkRecursive()`, which processes nested arrays, `walk()` works only at the first level
     * - Unlike `eachRecursive()`, which is immutable and recursive, `walk()` is mutable and flat
     *
     * This method is the mutable counterpart to the immutable `each()` method.
     * Use `walk()` when you need to modify the array in-place without creating a copy.
     * Use `each()` when you need to preserve the original array and work with a transformed copy.
     *
     * IMPORTANT: Since this method modifies the current object, it's not suitable for
     * method chaining where immutability is expected. For chaining immutable operations,
     * use `each()` instead.
     *
     *
     * Применяет callback-функцию к каждому элементу на месте (изменяет экземпляр).
     *
     * Этот метод эквивалентен функции PHP `array_walk()` с ключевыми особенностями:
     * 1. Изменяет ТЕКУЩИЙ экземпляр CoverArray (мутабельная операция)
     * 2. Callback получает значение ПО ССЫЛКЕ (может изменять напрямую)
     * 3. Сохраняет все оригинальные ключи (ассоциативные и числовые)
     * 4. Автоматически преобразует массивы в экземпляры CoverArray при установке
     *
     * ОТЛИЧИЯ от других методов:
     * - В отличие от `each()`, который возвращает новый экземпляр, `walk()` изменяет текущий экземпляр
     * - В отличие от `map()`, который переиндексирует числовые ключи, `walk()` сохраняет все оригинальные ключи
     * - В отличие от `walkRecursive()`, который обрабатывает вложенные массивы, `walk()` работает только на первом уровне
     * - В отличие от `eachRecursive()`, который иммутабельный и рекурсивный, `walk()` мутабельный и плоский
     *
     * Этот метод является мутабельным аналогом иммутабельного метода `each()`.
     * Используйте `walk()`, когда нужно изменить массив на месте без создания копии.
     * Используйте `each()`, когда нужно сохранить оригинальный массив и работать с преобразованной копией.
     *
     * ВАЖНО: Поскольку этот метод изменяет текущий объект, он не подходит для
     * цепочек вызовов, где ожидается иммутабельность. Для иммутабельных цепочек
     * используйте метод `each()`.
     *
     * @param callable $callback Callback function that receives value by reference.
     *                           Signature: `function(mixed &$value, mixed $key): void`
     *                           The callback can modify $value directly.
     *                           Callback-функция, получающая значение по ссылке.
     *                           Сигнатура: `function(mixed &$value, mixed $key): void`
     *                           Callback может изменять $value напрямую.
     * @return static Returns $this for method chaining.
     *                Возвращает $this для цепочек вызовов.
     *
     * @example
     * $arr = CoverArray::fromArray(['a' => 1, 'b' => 2]);
     * $arr->walk(function(&$value, $key) {
     *     $value = $key . ':' . ($value * 2);
     * });
     * // $arr is now: ['a' => 'a:2', 'b' => 'b:4']
     *
     * @see array_walk()
     * @see CoverArray::each() For immutable transformation
     *                         Для иммутабельного преобразования
     * @see CoverArray::map() For transformation without key preservation
     *                        Для преобразования без сохранения ключей
     * @see CoverArray::walkRecursive() For recursive mutable transformation
     *                                  Для рекурсивного мутабельного преобразования
     */
    final public function walk(callable $callback): static
    {
        foreach ($this->data as $key => &$value) {
            $callback($value, $key);
        }

        return $this;
    }

    /**
     * Recursively applies a callback function to each element in-place (mutates the instance).
     *
     * This method recursively processes all elements of the array, including nested arrays,
     * applying the callback function to each leaf node. It modifies the CURRENT CoverArray
     * instance in-place, preserving the complete hierarchical structure.
     *
     * DIFFERENCES from other methods:
     * - Unlike `walk()`, which processes only the first level, `walkRecursive()` processes all nesting levels
     * - Unlike `eachRecursive()`, which returns a new instance, `walkRecursive()` modifies the current instance
     * - Unlike `map()`, which re-indexes keys, `walkRecursive()` preserves the complete nested structure
     * - Unlike `each()`, which is immutable and flat, `walkRecursive()` is mutable and recursive
     *
     * KEY CHARACTERISTICS:
     * - Mutable operation (modifies current CoverArray)
     * - Recursively processes all nesting levels
     * - Preserves the complete hierarchical structure
     * - Automatically converts nested arrays to CoverArray instances
     * - Callback can modify leaf values by reference
     *
     * Use `walkRecursive()` when:
     * - You need to modify deeply nested arrays in-place
     * - You want to avoid creating copies of large nested structures
     * - You need to preserve the complete hierarchical structure
     * - You need to modify leaf values directly by reference
     *
     *
     * Рекурсивно применяет callback-функцию к каждому элементу на месте (изменяет экземпляр).
     *
     * Этот метод рекурсивно обрабатывает все элементы массива, включая вложенные массивы,
     * применяя callback-функцию к каждому конечному узлу. Он изменяет ТЕКУЩИЙ экземпляр
     * CoverArray на месте, сохраняя полную иерархическую структуру.
     *
     * ОТЛИЧИЯ от других методов:
     * - В отличие от `walk()`, который обрабатывает только первый уровень, `walkRecursive()` обрабатывает все уровни вложенности
     * - В отличие от `eachRecursive()`, который возвращает новый экземпляр, `walkRecursive()` изменяет текущий экземпляр
     * - В отличие от `map()`, который переиндексирует ключи, `walkRecursive()` сохраняет полную вложенную структуру
     * - В отличие от `each()`, который иммутабельный и плоский, `walkRecursive()` мутабельный и рекурсивный
     *
     * КЛЮЧЕВЫЕ ХАРАКТЕРИСТИКИ:
     * - Мутабельная операция (изменяет текущий CoverArray)
     * - Рекурсивно обрабатывает все уровни вложенности
     * - Сохраняет полную иерархическую структуру
     * - Автоматически преобразует вложенные массивы в экземпляры CoverArray
     * - Callback может изменять конечные значения по ссылке
     *
     * Используйте `walkRecursive()`, когда:
     * - Нужно изменить глубоко вложенные массивы на месте
     * - Нужно избежать создания копий больших вложенных структур
     * - Нужно сохранить полную иерархическую структуру
     * - Нужно изменять конечные значения напрямую по ссылке
     *
     * @param callable $callback Callback function that receives value by reference.
     *                           Signature: `function(mixed &$value, mixed $key): void`
     *                           The callback can modify $value directly.
     *                           Callback-функция, получающая значение по ссылке.
     *                           Сигнатура: `function(mixed &$value, mixed $key): void`
     *                           Callback может изменять $value напрямую.
     * @return static Returns $this for method chaining.
     *                Возвращает $this для цепочек вызовов.
     *
     * @example
     * $arr = CoverArray::fromArray(['a' => 1, 'b' => ['c' => 2, 'd' => ['e' => 3]]]);
     * $arr->walkRecursive(function(&$value, $key) {
     *     if (is_int($value)) {
     *         $value = $value * 2;
     *     }
     * });
     * // $arr is now: ['a' => 2, 'b' => ['c' => 4, 'd' => ['e' => 6]]]
     *
     * @see array_walk_recursive()
     * @see CoverArray::walk() For flat mutable transformation
     *                         Для плоского мутабельного преобразования
     * @see CoverArray::eachRecursive() For recursive immutable transformation
     *                                  Для рекурсивного иммутабельного преобразования
     * @see CoverArray::each() For flat immutable transformation
     *                         Для плоского иммутабельного преобразования
     */
    final public function walkRecursive(callable $callback): static
    {
        $walker = function (&$data) use (&$walker, $callback) {
            foreach ($data as $key => &$value) {
                if (is_array($value) && !is_callable($value)) {
                    // Recursively process the array
                    $walker($value);
                    // Convert array to CoverArray
                    $data[$key] = new static($value);
                } elseif ($value instanceof self) {
                    // If it's already a CoverArray, call walkRecursive on it
                    $value->walkRecursive($callback);
                } else {
                    // Leaf node - apply callback
                    $callback($value, $key);
                }
            }
        };

        $walker($this->data);
        return $this;
    }

    /**
     * Sorts an array in descending order and maintains index association (arsort equivalent).
     *
     * Sorts an array in descending order and maintains index association.
     *
     * Сортирует массив в порядке убывания, сохраняя ассоциацию индексов (эквивалент arsort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see arsort()
     */
    final public function arsort(int $flags = SORT_REGULAR): static
    {
        // TODO: Implement arsort equivalent
        arsort($this->data, $flags);
        return $this;
    }

    /**
     * Sorts an array in ascending order and maintains index association (asort equivalent).
     *
     * Sorts an array in ascending order and maintains index association.
     *
     * Сортирует массив в порядке возрастания, сохраняя ассоциацию индексов (эквивалент asort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see asort()
     */
    final public function asort(int $flags = SORT_REGULAR): static
    {
        // TODO: Implement asort equivalent
        asort($this->data, $flags);
        return $this;
    }

    /**
     * Creates a CoverArray containing variables and their values (compact equivalent).
     *
     * Creates a CoverArray containing variables and their values.
     *
     * Создаёт массив с названиями и значениями переменных (эквивалент compact).
     *
     * @param mixed ...$vars Variable names.
     *                       Имена переменных.
     * @return static New CoverArray instance with variables and values.
     *                Новый экземпляр CoverArray с переменными и их значениями.
     * @see compact()
     */
    final public static function compact(mixed ...$vars): static
    {
        // TODO: Implement compact equivalent
        return new static(compact(...$vars));
    }

    /**
     * Implementing the Countable interface.
     *
     * Реализует интерфейс Countable.
     *
     * @return int
     */
    final public function count(): int
    {
        return count($this->data);
    }

    /**
     * Returns the current element in the array (current equivalent).
     *
     * Returns the current element in the array.
     *
     * Возвращает текущий элемент массива (эквивалент current).
     *
     * @return mixed The current element value.
     *               Текущее значение элемента.
     * @see current()
     */
    final public function current(): mixed
    {
        // TODO: Implement current equivalent
        return current($this->data);
    }

    /**
     * Sets the internal pointer to the last element (end equivalent).
     *
     * Sets the internal pointer of an array to its last element.
     *
     * Устанавливает внутренний указатель массива на последний элемент (эквивалент end).
     *
     * @return mixed The value of the last element or false if empty.
     *               Значение последнего элемента или false если массив пуст.
     * @see end()
     */
    final public function end(): mixed
    {
        // TODO: Implement end equivalent
        return end($this->data);
    }

    /**
     * Imports variables from the CoverArray into the current symbol table (extract equivalent).
     *
     * Imports variables from the CoverArray into the current symbol table.
     *
     * Импортирует переменные массива в текущую таблицу символов (эквивалент extract).
     *
     * @param int $flags The way invalid/numeric keys and collisions are treated.
     *                   Способ обработки недопустимых/числовых ключей и коллизий.
     * @param string $prefix Prefix for variable names.
     *                       Префикс для имен переменных.
     * @return int Number of variables successfully imported.
     *             Количество успешно импортированных переменных.
     * @see extract()
     */
    final public function extract(int $flags = EXTR_OVERWRITE, string $prefix = ''): int
    {
        // TODO: Implement extract equivalent
        return extract($this->data, $flags, $prefix);
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
     * Gets the key of the current array element (key equivalent).
     *
     * Gets the key of the current array element.
     *
     * Получает ключ массива (эквивалент key).
     *
     * @return int|string|null The key of the current array element.
     *                         Ключ текущего элемента массива.
     * @see key()
     */
    final public function key(): int|string|null
    {
        // TODO: Implement key equivalent
        return key($this->data);
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
     * Sorts an array by key in descending order (krsort equivalent).
     *
     * Sorts an array by key in descending order.
     *
     * Сортирует массив по ключу в порядке убывания (эквивалент krsort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see krsort()
     */
    final public function krsort(int $flags = SORT_REGULAR): static
    {
        // TODO: Implement krsort equivalent
        krsort($this->data, $flags);
        return $this;
    }

    /**
     * Sorts an array by key in ascending order (ksort equivalent).
     *
     * Sorts an array by key in ascending order.
     *
     * Сортирует массив по ключу в порядке возрастания (эквивалент ksort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see ksort()
     */
    final public function ksort(int $flags = SORT_REGULAR): static
    {
        // TODO: Implement ksort equivalent
        ksort($this->data, $flags);
        return $this;
    }

    /**
     * Assigns variables as if they were an array (list equivalent).
     *
     * Assigns variables as if they were an array.
     *
     * Присваивает переменным значения как массиву (эквивалент list).
     *
     * @param mixed ...$vars Variables to assign.
     *                       Переменные для присвоения.
     * @return array Array of assigned values.
     *               Массив присвоенных значений.
     * @see list()
     */
    final public function list(mixed &...$vars): array
    {
        // TODO: Implement list equivalent
        // Note: This is tricky to implement as a method
        //        return list(...$vars) = $this->data;
        return [];
    }

    /**
     * Sorts an array using natural order case-insensitive algorithm (natcasesort equivalent).
     *
     * Sorts an array using a case-insensitive "natural order" algorithm.
     *
     * Сортирует массив алгоритмом естественной сортировки без учёта регистра (эквивалент natcasesort).
     *
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see natcasesort()
     */
    final public function natcasesort(): static
    {
        // TODO: Implement natcasesort equivalent
        natcasesort($this->data);
        return $this;
    }

    /**
     * Sorts an array using natural order algorithm (natsort equivalent).
     *
     * Sorts an array using a "natural order" algorithm.
     *
     * Сортирует массив алгоритмом «естественного упорядочивания» (эквивалент natsort).
     *
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see natsort()
     */
    final public function natsort(): static
    {
        // TODO: Implement natsort equivalent
        natsort($this->data);
        return $this;
    }

    /**
     * Advances the internal array pointer (next equivalent).
     *
     * Advances the internal array pointer.
     *
     * Сдвигает внутренний указатель массива на одну позицию вперёд (эквивалент next).
     *
     * @return mixed The value of the next element or false if no more elements.
     *               Значение следующего элемента или false если больше нет элементов.
     * @see next()
     */
    final public function next(): mixed
    {
        // TODO: Implement next equivalent
        return next($this->data);
    }

    /**
     * Alias of current() (pos equivalent).
     *
     * Alias of current() method.
     *
     * Псевдоним метода current() (эквивалент pos).
     *
     * @return mixed The current element value.
     *               Текущее значение элемента.
     * @see pos()
     * @see CoverArray::current()
     */
    final public function pos(): mixed
    {
        return $this->current();
    }

    /**
     * Rewinds the internal array pointer (prev equivalent).
     *
     * Rewinds the internal array pointer.
     *
     * Сдвигает внутренний указатель массива на одну позицию назад (эквивалент prev).
     *
     * @return mixed The value of the previous element or false if no more elements.
     *               Значение предыдущего элемента или false если больше нет элементов.
     * @see prev()
     */
    final public function prev(): mixed
    {
        // TODO: Implement prev equivalent
        return prev($this->data);
    }

    /**
     * Creates a CoverArray containing a range of elements (range equivalent).
     *
     * Creates a CoverArray containing a range of elements.
     *
     * Создаёт массив, который содержит диапазон элементов (эквивалент range).
     *
     * @param mixed $start First value of the sequence.
     *                     Начальное значение последовательности.
     * @param mixed $end End value of the sequence.
     *                   Конечное значение последовательности.
     * @param int|float $step Increment between values.
     *                        Шаг между значениями.
     * @return static New CoverArray instance containing the range.
     *                Новый экземпляр CoverArray, содержащий диапазон.
     * @see range()
     */
    final public static function range(mixed $start, mixed $end, int|float $step = 1): static
    {
        // TODO: Implement range equivalent
        return new static(range($start, $end, $step));
    }

    /**
     * Resets the internal pointer to the first element (reset equivalent).
     *
     * Sets the internal pointer of an array to its first element.
     *
     * Устанавливает внутренний указатель массива на первый элемент (эквивалент reset).
     *
     * @return mixed The value of the first element or false if empty.
     *               Значение первого элемента или false если массив пуст.
     * @see reset()
     */
    final public function reset(): mixed
    {
        // TODO: Implement reset equivalent
        return reset($this->data);
    }

    /**
     * Sorts an array in descending order (rsort equivalent).
     *
     * Sorts an array in descending order.
     *
     * Сортирует массив в порядке убывания (эквивалент rsort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see rsort()
     */
    final public function rsort(int $flags = SORT_REGULAR): static
    {
        // TODO: Implement rsort equivalent
        rsort($this->data, $flags);
        return $this;
    }

    /**
     * Shuffles the array (shuffle equivalent).
     *
     * Shuffles (randomizes the order of) the elements in the array.
     *
     * Перемешивает массив (эквивалент shuffle).
     *
     * @return static Current CoverArray instance (shuffled in place).
     *                Текущий экземпляр CoverArray (перемешанный на месте).
     * @see shuffle()
     */
    final public function shuffle(): static
    {
        // TODO: Implement shuffle equivalent
        shuffle($this->data);
        return $this;
    }

    /**
     * Sorts an array in ascending order (sort equivalent).
     *
     * Sorts an array in ascending order.
     *
     * Сортирует массив по возрастанию (эквивалент sort).
     *
     * @param int $flags Sorting flags (SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE).
     *                   Флаги сортировки.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see sort()
     */
    final public function sort(int $flags = SORT_REGULAR): static
    {
        sort($this->data, $flags);

        return $this;
    }

    /**
     * Sorts an array with a user-defined comparison function and maintains index association (uasort equivalent).
     *
     * Sorts an array with a user-defined comparison function and maintains index association.
     *
     * Сортирует массив пользовательской функцией сравнения, сохраняя ассоциацию индексов (эквивалент uasort).
     *
     * @param callable $callback The comparison function.
     *                           Функция сравнения.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see uasort()
     */
    final public function uasort(callable $callback): static
    {
        // TODO: Implement uasort equivalent
        uasort($this->data, $callback);
        return $this;
    }

    /**
     * Sorts an array by keys using a user-defined comparison function (uksort equivalent).
     *
     * Sorts an array by keys using a user-defined comparison function.
     *
     * Сортирует массив по ключам пользовательской функцией сравнения (эквивалент uksort).
     *
     * @param callable $callback The comparison function.
     *                           Функция сравнения.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see uksort()
     */
    final public function uksort(callable $callback): static
    {
        // TODO: Implement uksort equivalent
        uksort($this->data, $callback);
        return $this;
    }

    /**
     * Sorts an array by values using a user-defined comparison function (usort equivalent).
     *
     * Sorts an array by values using a user-defined comparison function.
     *
     * Сортирует массив по значениям через пользовательскую функцию сравнения (эквивалент usort).
     *
     * @param callable $callback The comparison function.
     *                           Функция сравнения.
     * @return static Current CoverArray instance (sorted in place).
     *                Текущий экземпляр CoverArray (сортируется на месте).
     * @see usort()
     */
    final public function usort(callable $callback): static
    {
        $data = $this->getDataAsArray();
        usort($data, $callback);

        return $this->clear()->setData($data);
    }

    // Additional CoverArray-specific methods (not direct equivalents of PHP array functions)

    /**
     * Applies a callback function to each element and returns a new instance.
     *
     * This method transforms each element of the array using the provided callback
     * function, which receives both the VALUE and KEY of each element. It returns
     * a NEW CoverArray instance, leaving the original unchanged (immutable operation).
     *
     * DIFFERENCES from other methods:
     * - Unlike `walk()`, which modifies the current instance, `each()` returns a new instance
     * - Unlike `map()`, which re-indexes numeric keys, `each()` preserves all original keys
     * - Unlike `eachRecursive()`, which processes nested arrays, `each()` works only at the first level
     * - Unlike `walkRecursive()`, which modifies nested structures, `each()` is immutable and flat
     *
     * KEY CHARACTERISTICS:
     * - Immutable operation (returns new CoverArray)
     * - Preserves all original keys (associative and numeric)
     * - Callback receives both value AND key as parameters
     * - Works only at the first nesting level
     *
     * Use `each()` when:
     * - You need to preserve associative keys
     * - You need both value AND key in the transformation
     * - You want an immutable operation (original unchanged)
     * - You're transforming only the first level of the array
     *
     *
     * Применяет callback-функцию к каждому элементу и возвращает новый экземпляр.
     *
     * Этот метод преобразует каждый элемент массива с помощью предоставленной callback-функции,
     * которая получает как ЗНАЧЕНИЕ, так и КЛЮЧ каждого элемента. Он возвращает НОВЫЙ
     * экземпляр CoverArray, оставляя оригинал неизменным (иммутабельная операция).
     *
     * ОТЛИЧИЯ от других методов:
     * - В отличие от `walk()`, который изменяет текущий экземпляр, `each()` возвращает новый экземпляр
     * - В отличие от `map()`, который переиндексирует числовые ключи, `each()` сохраняет все оригинальные ключи
     * - В отличие от `eachRecursive()`, который обрабатывает вложенные массивы, `each()` работает только на первом уровне
     * - В отличие от `walkRecursive()`, который изменяет вложенные структуры, `each()` иммутабельный и плоский
     *
     * КЛЮЧЕВЫЕ ХАРАКТЕРИСТИКИ:
     * - Иммутабельная операция (возвращает новый CoverArray)
     * - Сохраняет все оригинальные ключи (ассоциативные и числовые)
     * - Callback получает и значение, И ключ в качестве параметров
     * - Работает только на первом уровне вложенности
     *
     * Используйте `each()`, когда:
     * - Нужно сохранить ассоциативные ключи
     * - Нужны и значение, И ключ в преобразовании
     * - Нужна иммутабельная операция (оригинал не изменяется)
     * - Преобразовываете только первый уровень массива
     *
     * @param callable $callback Callback function: `function(mixed $value, mixed $key): mixed`
     *                           Callback-функция: `function(mixed $value, mixed $key): mixed`
     * @return static New CoverArray instance with transformed values.
     *                Новый экземпляр CoverArray с преобразованными значениями.
     *
     * @example
     * $arr = CoverArray::fromArray(['a' => 1, 'b' => 2]);
     * $result = $arr->each(fn($v, $k) => $k . ':' . ($v * 2));
     * // Result: ['a' => 'a:2', 'b' => 'b:4']
     *
     * @see CoverArray::map() For transformation with key re-indexing
     *                        Для преобразования с переиндексацией ключей
     * @see CoverArray::walk() For mutable transformation
     *                         Для мутабельного преобразования
     * @see CoverArray::eachRecursive() For recursive immutable transformation
     *                                  Для рекурсивного иммутабельного преобразования
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
     * Recursively applies a callback function to each element and returns a new instance.
     *
     * This method transforms each element of the array recursively using the provided callback
     * function, which receives both the VALUE and KEY of each element at all nesting levels.
     * It returns a NEW CoverArray instance, leaving the original unchanged (immutable operation).
     *
     * DIFFERENCES from other methods:
     * - Unlike `each()`, which works only at the first level, `eachRecursive()` processes all nested arrays
     * - Unlike `walkRecursive()`, which modifies the current instance, `eachRecursive()` returns a new instance
     * - Unlike `map()`, which re-indexes keys, `eachRecursive()` preserves the complete nested structure
     * - Unlike `walk()`, which is mutable and flat, `eachRecursive()` is immutable and recursive
     *
     * KEY CHARACTERISTICS:
     * - Immutable operation (returns new CoverArray)
     * - Recursively processes all nesting levels
     * - Preserves the complete hierarchical structure
     * - Callback receives both value AND key at each level
     *
     * Use `eachRecursive()` when:
     * - You need to transform deeply nested arrays
     * - You want to preserve the complete hierarchical structure
     * - You need an immutable operation that doesn't modify the original
     * - You need access to keys at all nesting levels
     *
     *
     * Рекурсивно применяет callback-функцию к каждому элементу и возвращает новый экземпляр.
     *
     * Этот метод рекурсивно преобразует каждый элемент массива с помощью предоставленной
     * callback-функции, которая получает как ЗНАЧЕНИЕ, так и КЛЮЧ каждого элемента на всех
     * уровнях вложенности. Он возвращает НОВЫЙ экземпляр CoverArray, оставляя оригинал
     * неизменным (иммутабельная операция).
     *
     * ОТЛИЧИЯ от других методов:
     * - В отличие от `each()`, который работает только на первом уровне, `eachRecursive()` обрабатывает все вложенные массивы
     * - В отличие от `walkRecursive()`, который изменяет текущий экземпляр, `eachRecursive()` возвращает новый экземпляр
     * - В отличие от `map()`, который переиндексирует ключи, `eachRecursive()` сохраняет полную вложенную структуру
     * - В отличие от `walk()`, который мутабельный и плоский, `eachRecursive()` иммутабельный и рекурсивный
     *
     * КЛЮЧЕВЫЕ ХАРАКТЕРИСТИКИ:
     * - Иммутабельная операция (возвращает новый CoverArray)
     * - Рекурсивно обрабатывает все уровни вложенности
     * - Сохраняет полную иерархическую структуру
     * - Callback получает и значение, И ключ на каждом уровне
     *
     * Используйте `eachRecursive()`, когда:
     * - Нужно преобразовать глубоко вложенные массивы
     * - Нужно сохранить полную иерархическую структуру
     * - Нужна иммутабельная операция, не изменяющая оригинал
     * - Нужен доступ к ключам на всех уровнях вложенности
     *
     * @param callable $callback Callback function: `function(mixed $value, mixed $key): mixed`
     *                           Callback-функция: `function(mixed $value, mixed $key): mixed`
     * @return static New CoverArray instance with recursively transformed values.
     *                Новый экземпляр CoverArray с рекурсивно преобразованными значениями.
     *
     * @example
     * $arr = CoverArray::fromArray(['a' => 1, 'b' => ['c' => 2, 'd' => ['e' => 3]]]);
     * $result = $arr->eachRecursive(fn($v, $k) => is_int($v) ? $v * 2 : $v);
     * // Result: ['a' => 2, 'b' => ['c' => 4, 'd' => ['e' => 6]]]
     *
     * @see CoverArray::each() For flat immutable transformation
     *                         Для плоского иммутабельного преобразования
     * @see CoverArray::walkRecursive() For recursive mutable transformation
     *                                  Для рекурсивного мутабельного преобразования
     * @see CoverArray::map() For transformation with key re-indexing
     *                        Для преобразования с переиндексацией ключей
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

    /*******************************************************************************************************************
     * Start protected functions
     ******************************************************************************************************************/

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
     * Normalizes data for PHP array functions.
     *
     * Converts CoverArray instances to plain PHP arrays recursively,
     * while leaving other data types unchanged. This method is used internally
     * to ensure compatibility when passing data to PHP's native array functions
     * that expect plain arrays as arguments.
     *
     * The method handles three cases:
     * 1. CoverArray instances: converts to plain array using getDataAsArray()
     * 2. Plain arrays: returns unchanged
     * 3. Other types (scalars, objects, resources): returns as-is
     *
     *
     * Нормализует данные для функций массивов PHP.
     *
     * Преобразует экземпляры CoverArray в обычные массивы PHP рекурсивно,
     * оставляя другие типы данных без изменений. Этот метод используется внутренне
     * для обеспечения совместимости при передаче данных в нативные функции
     * массивов PHP, которые ожидают обычные массивы в качестве аргументов.
     *
     * Метод обрабатывает три случая:
     * 1. Экземпляры CoverArray: преобразует в обычный массив с помощью getDataAsArray()
     * 2. Обычные массивы: возвращает без изменений
     * 3. Другие типы (скаляры, объекты, ресурсы): возвращает как есть
     *
     * @param mixed $data Data to normalize (CoverArray, array, or any other type).
     *                    Данные для нормализации (CoverArray, массив или любой другой тип).
     * @return mixed Plain PHP array if input was CoverArray or array, original value otherwise.
     *               Обычный массив PHP если на входе был CoverArray или массив, исходное значение в противном случае.
     *
     * @see CoverArray::getDataAsArray()
     */
    final protected static function convertToPlain(mixed $data): mixed
    {
        return $data instanceof self ? $data->getDataAsArray() : $data;
    }
}