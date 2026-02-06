<?php

declare(strict_types=1);

namespace Krugozor\Cover;

/**
 * Simple trait providing basic array-like object functionality.
 *
 * This trait offers a simple interface for working with data stored in an array property.
 * It provides magic methods for property access, basic data manipulation methods,
 * and can be used in any class that needs array-like behavior with object syntax.
 * The trait is designed to be minimal and reusable in various contexts.
 *
 *
 * Простой трейт, предоставляющий базовую функциональность объекта, похожего на массив.
 *
 * Этот трейт предоставляет простой интерфейс для работы с данными, хранящимися в свойстве-массиве.
 * Он включает магические методы для доступа к свойствам, базовые методы для управления данными
 * и может использоваться в любом классе, которому требуется поведение, похожее на массив, с синтаксисом объектов.
 * Трейт разработан минималистичным и может быть повторно использован в различных контекстах.
 *
 * @package Krugozor\Cover
 * @author Vasiliy Makogon
 * @link https://github.com/Vasiliy-Makogon/PHP-Collection
 */
trait Simple
{
    /**
     * Internal data storage array.
     *
     * This array holds all the data managed by the trait.
     * It can be accessed directly in classes using this trait,
     * though it's recommended to use the provided methods for data manipulation.
     *
     *
     * Внутренний массив для хранения данных.
     *
     * Этот массив содержит все данные, управляемые трейтом.
     * К нему можно получить прямой доступ в классах, использующих этот трейт,
     * хотя рекомендуется использовать предоставленные методы для работы с данными.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Magic getter for accessing data via object property syntax.
     *
     * Allows accessing array elements as object properties (e.g., $obj->key).
     * Returns the value associated with the given key, or null if the key doesn't exist.
     * This method provides convenient syntax but doesn't support nested access.
     *
     *
     * Магический геттер для доступа к данным через синтаксис свойств объекта.
     *
     * Позволяет получать доступ к элементам массива как к свойствам объекта (например, $obj->key).
     * Возвращает значение, связанное с указанным ключом, или null, если ключ не существует.
     * Этот метод предоставляет удобный синтаксис, но не поддерживает вложенный доступ.
     *
     * @param string $key The property name / array key to retrieve.
     *                    Имя свойства / ключ массива для получения.
     * @return mixed The value associated with the key, or null if not found.
     *               Значение, связанное с ключом, или null, если не найдено.
     *
     * @example
     * $obj->key = 'value';
     * echo $obj->key; // 'value'
     * echo $obj->nonExistent; // null
     *
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#object.get
     * @see Simple::item()
     */
    public function __get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Magic setter for assigning data via object property syntax.
     *
     * Allows setting array elements as object properties (e.g., $obj->key = 'value').
     * The value is stored directly without any conversion or validation.
     * For CoverArray, this method is overridden to convert arrays to CoverArray instances.
     *
     *
     * Магический сеттер для присвоения данных через синтаксис свойств объекта.
     *
     * Позволяет устанавливать элементы массива как свойства объекта (например, $obj->key = 'value').
     * Значение сохраняется напрямую без преобразования или валидации.
     * В CoverArray этот метод переопределен для преобразования массивов в экземпляры CoverArray.
     *
     * @param string $key The property name / array key to assign.
     *                    Имя свойства / ключ массива для присвоения.
     * @param mixed $value The value to store.
     *                     Значение для хранения.
     *
     * @example
     * $obj->name = 'John';
     * $obj->age = 30;
     *
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#object.set
     */
    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Magic isset checker for verifying property existence.
     *
     * Checks whether a property/array key exists and is not null.
     * This method is called when isset() or empty() is used on object properties.
     *
     *
     * Магический проверщик isset для проверки существования свойства.
     *
     * Проверяет, существует ли свойство/ключ массива и не является ли null.
     * Этот метод вызывается при использовании isset() или empty() на свойствах объекта.
     *
     * @param string $key The property name / array key to check.
     *                    Имя свойства / ключ массива для проверки.
     * @return bool True if the key exists and is not null, false otherwise.
     *              Возвращает true, если ключ существует и не равен null, иначе false.
     *
     * @example
     * $obj->key = 'value';
     * isset($obj->key); // true
     * isset($obj->nonExistent); // false
     *
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#object.isset
     * @see isset()
     */
    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Magic unset for removing properties.
     *
     * Removes a property/array key from the data array.
     * This method is called when unset() is used on object properties.
     *
     *
     * Магический unset для удаления свойств.
     *
     * Удаляет свойство/ключ массива из массива данных.
     * Этот метод вызывается при использовании unset() на свойствах объекта.
     *
     * @param string $key The property name / array key to remove.
     *                    Имя свойства / ключ массива для удаления.
     *
     * @example
     * $obj->key = 'value';
     * unset($obj->key);
     * echo $obj->key; // null
     *
     * @see https://www.php.net/manual/en/language.oop5.overloading.php#object.unset
     * @see unset()
     */
    public function __unset(string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Retrieves an element by key with explicit method call.
     *
     * Similar to the __get magic method but can be called explicitly.
     * Useful for numeric indices or when the key is stored in a variable.
     * This method doesn't trigger magic method overhead and can be used
     * in contexts where explicit method calls are preferred.
     *
     *
     * Получает элемент по ключу с явным вызовом метода.
     *
     * Похож на магический метод __get, но может быть вызван явно.
     * Полезен для числовых индексов или когда ключ хранится в переменной.
     * Этот метод не вызывает накладных расходов магических методов и может использоваться
     * в контекстах, где предпочтительны явные вызовы методов.
     *
     * @param mixed $key The key to retrieve (can be string, integer, etc.).
     *                   Ключ для получения (может быть строкой, целым числом и т.д.).
     * @return mixed The value associated with the key, or null if not found.
     *               Значение, связанное с ключом, или null, если не найдено.
     *
     * @example
     * $obj->item('name'); // Returns value for key 'name'
     * $obj->item(0); // Returns value for numeric index 0
     * $key = 'dynamicKey';
     * $obj->item($key); // Returns value for dynamic key
     *
     * @see Simple::__get()
     */
    public function item(mixed $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Sets the internal data from an iterable source.
     *
     * Replaces all existing data with the provided iterable.
     * Each key-value pair from the iterable is assigned to the internal array.
     * If null is provided, the array remains unchanged (use clear() to empty it).
     *
     *
     * Устанавливает внутренние данные из итерируемого источника.
     *
     * Заменяет все существующие данные предоставленным итерируемым объектом.
     * Каждая пара ключ-значение из итерируемого объекта присваивается внутреннему массиву.
     * Если предоставлен null, массив остается без изменений (используйте clear() для очистки).
     *
     * @param iterable|null $data The data to set. Can be an array, Traversable, or null.
     *                            Данные для установки. Может быть массивом, Traversable или null.
     * @return static Returns the current instance for method chaining.
     *                Возвращает текущий экземпляр для цепочек вызовов.
     *
     * @example
     * $obj->setData(['name' => 'John', 'age' => 30]);
     * $obj->setData(new ArrayIterator(['key' => 'value']));
     *
     * @see Simple::clear()
     */
    public function setData(?iterable $data): static
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Returns the internal data array as-is.
     *
     * Returns the raw internal $data array without any conversion or transformation.
     * Unlike CoverArray::getDataAsArray(), this method does not recursively convert
     * nested objects — it returns the data exactly as stored.
     *
     *
     * Возвращает внутренний массив данных как есть.
     *
     * Возвращает необработанный внутренний массив $data без какого-либо преобразования
     * или трансформации. В отличие от CoverArray::getDataAsArray(), этот метод не выполняет
     * рекурсивное преобразование вложенных объектов — он возвращает данные в точности
     * так, как они хранятся.
     *
     * @return array The internal data array.
     *               Внутренний массив данных.
     *
     * @example
     * $obj->name = 'John';
     * $obj->age = 30;
     * $obj->getData(); // ['name' => 'John', 'age' => 30]
     *
     * @see Simple::setData()
     * @see Simple::clear()
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Clears all data from the internal array.
     *
     * Resets the internal $data array to an empty array.
     * This method provides a clean way to remove all stored data.
     * Returns the instance for method chaining.
     *
     *
     * Очищает все данные из внутреннего массива.
     *
     * Сбрасывает внутренний массив $data в пустой массив.
     * Этот метод предоставляет чистый способ удаления всех сохраненных данных.
     * Возвращает экземпляр для цепочек вызовов.
     *
     * @return static Returns the current instance for method chaining.
     *                Возвращает текущий экземпляр для цепочек вызовов.
     *
     * @see Simple::setData()
     */
    public function clear(): static
    {
        $this->data = [];

        return $this;
    }
}