<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class IssetTest extends TestCase
{
    /**
     * Tests isset() with existing scalar values.
     *
     * This test verifies that the __isset method correctly identifies
     * the existence of keys with scalar values (integers, strings, etc.)
     * when using the isset() language construct.
     *
     *
     * Тестирование isset() с существующими скалярными значениями.
     *
     * Этот тест проверяет, что метод __isset корректно определяет
     * существование ключей со скалярными значениями (целые числа, строки и т.д.)
     * при использовании языковой конструкции isset().
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithScalarValues(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'zero' => 0,
            'empty_string' => ''
        ]);

        $this->assertTrue(isset($array->string));
        $this->assertTrue(isset($array->int));
        $this->assertTrue(isset($array->float));
        $this->assertTrue(isset($array->bool_true));
        $this->assertTrue(isset($array->bool_false));
        $this->assertTrue(isset($array->zero));
        $this->assertTrue(isset($array->empty_string));
    }

    /**
     * Tests isset() with null values.
     *
     * This test ensures that the __isset method returns false for keys
     * that exist but have null values, which is consistent with PHP's
     * standard isset() behavior.
     *
     *
     * Тестирование isset() со значениями null.
     *
     * Этот тест гарантирует, что метод __isset возвращает false для ключей,
     * которые существуют, но имеют значения null, что согласуется со
     * стандартным поведением isset() в PHP.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithNullValues(): void
    {
        $array = new NewTypeArray([
            'null_value' => null,
            'explicit_null' => null
        ]);

        $this->assertFalse(isset($array->null_value));
        $this->assertFalse(isset($array->explicit_null));
        $this->assertFalse(isset($array->non_existent_key));
    }

    /**
     * Tests isset() with non-existent keys.
     *
     * This test verifies that the __isset method returns false for keys
     * that do not exist in the data array, preventing errors when
     * checking for undefined properties.
     *
     *
     * Тестирование isset() с несуществующими ключами.
     *
     * Этот тест проверяет, что метод __isset возвращает false для ключей,
     * которые не существуют в массиве данных, предотвращая ошибки при
     * проверке неопределенных свойств.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithNonExistentKeys(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);

        $this->assertFalse(isset($array->non_existent));
        $this->assertFalse(isset($array->another_non_existent));
        $this->assertTrue(isset($array->existing));
    }

    /**
     * Tests isset() with object values.
     *
     * This test ensures that the __isset method correctly identifies
     * keys that have object values, returning true even if the object
     * itself might be considered "empty" in other contexts.
     *
     *
     * Тестирование isset() со значениями-объектами.
     *
     * Этот тест гарантирует, что метод __isset корректно определяет
     * ключи, имеющие объектные значения, возвращая true, даже если
     * сам объект может считаться "пустым" в других контекстах.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithObjectValues(): void
    {
        $array = new NewTypeArray([
            'object' => new stdClass(),
            'empty_object' => new stdClass(),
            'cover_array' => new NewTypeArray(),
            'nested_cover' => new NewTypeArray(['nested' => 'value'])
        ]);

        $this->assertTrue(isset($array->object));
        $this->assertTrue(isset($array->empty_object));
        $this->assertTrue(isset($array->cover_array));
        $this->assertTrue(isset($array->nested_cover));
    }

    /**
     * Tests isset() with array values.
     *
     * This test verifies that the __isset method works correctly with
     * array values, returning true for keys that contain arrays regardless
     * of whether the arrays are empty or not.
     *
     *
     * Тестирование isset() со значениями-массивами.
     *
     * Этот тест проверяет, что метод __isset корректно работает с
     * массивами-значениями, возвращая true для ключей, содержащих массивы,
     * независимо от того, пустые эти массивы или нет.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithArrayValues(): void
    {
        $array = new NewTypeArray([
            'empty_array' => [],
            'filled_array' => [1, 2, 3],
            'assoc_array' => ['key' => 'value']
        ]);

        $this->assertTrue(isset($array->empty_array));
        $this->assertTrue(isset($array->filled_array));
        $this->assertTrue(isset($array->assoc_array));
    }

    /**
     * Tests isset() with numeric keys.
     *
     * This test ensures that the __isset method works correctly with
     * numeric keys, which can be accessed as properties even though
     * this is not typical PHP object behavior.
     *
     *
     * Тестирование isset() с числовыми ключами.
     *
     * Этот тест гарантирует, что метод __isset корректно работает с
     * числовыми ключами, которые могут быть доступны как свойства,
     * хотя это и не является типичным поведением объектов в PHP.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithNumericKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'zero',
            1 => 'one',
            '2' => 'two', // строковый числовой ключ
        ]);

        $this->assertTrue(isset($array->{0}));
        $this->assertTrue(isset($array->{1}));
        $this->assertTrue(isset($array->{2}));
    }

    /**
     * Tests isset() with special string keys.
     *
     * This test verifies that the __isset method handles special string
     * keys correctly, including keys with spaces, special characters,
     * and unusual naming patterns.
     *
     *
     * Тестирование isset() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что метод __isset корректно обрабатывает
     * специальные строковые ключи, включая ключи с пробелами,
     * специальными символами и необычными шаблонами именования.
     *
     * @see CoverArray::__isset()
     */
    public function testIssetWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray([
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'key_with_underscores' => 'value4',
            'CamelCaseKey' => 'value5',
            '123numericStart' => 'value6'
        ]);

        $this->assertTrue(isset($array->{'key with spaces'}));
        $this->assertTrue(isset($array->{'key-with-dashes'}));
        $this->assertTrue(isset($array->{'key.with.dots'}));
        $this->assertTrue(isset($array->key_with_underscores));
        $this->assertTrue(isset($array->CamelCaseKey));
        $this->assertTrue(isset($array->{'123numericStart'}));
    }

    /**
     * Tests isset() after unsetting keys.
     *
     * This test ensures that the __isset method returns false for keys
     * that have been unset using the __unset method, maintaining
     * consistency with PHP's property unsetting behavior.
     *
     *
     * Тестирование isset() после удаления ключей.
     *
     * Этот тест гарантирует, что метод __isset возвращает false для ключей,
     * которые были удалены с помощью метода __unset, сохраняя
     * согласованность с поведением удаления свойств в PHP.
     *
     * @see CoverArray::__isset()
     * @see CoverArray::__unset()
     */
    public function testIssetAfterUnset(): void
    {
        $array = new NewTypeArray([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ]);

        $this->assertTrue(isset($array->key1));
        $this->assertTrue(isset($array->key2));
        $this->assertTrue(isset($array->key3));

        unset($array->key1);
        unset($array->key2);

        $this->assertFalse(isset($array->key1));
        $this->assertFalse(isset($array->key2));
        $this->assertTrue(isset($array->key3));
    }

    /**
     * Tests isset() with dynamically added properties.
     *
     * This test verifies that the __isset method works correctly with
     * properties that are added dynamically after object creation,
     * ensuring flexible property management.
     *
     *
     * Тестирование isset() с динамически добавленными свойствами.
     *
     * Этот тест проверяет, что метод __isset корректно работает со
     * свойствами, добавленными динамически после создания объекта,
     * обеспечивая гибкое управление свойствами.
     *
     * @see CoverArray::__isset()
     * @see CoverArray::__set()
     */
    public function testIssetWithDynamicProperties(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        $this->assertTrue(isset($array->initial));
        $this->assertFalse(isset($array->dynamic));

        // Динамически добавляем свойство
        $array->dynamic = 'new_value';
        $array->another_dynamic = null;

        $this->assertTrue(isset($array->dynamic));
        $this->assertFalse(isset($array->another_dynamic)); // null значение
        $this->assertFalse(isset($array->non_existent));
    }

    /**
     * Tests consistency between __isset() and offsetExists().
     *
     * Both methods use standard PHP isset() semantics:
     * - Return true if the key exists AND its value is not null
     * - Return false if the key doesn't exist OR its value is null
     *
     * This ensures uniform behavior for both property and array access syntax.
     *
     *
     * Тестирование согласованности между __isset() и offsetExists().
     *
     * Оба метода используют стандартную семантику PHP isset():
     * - Возвращают true, если ключ существует И его значение не равно null
     * - Возвращают false, если ключ не существует ИЛИ его значение равно null
     *
     * Это обеспечивает единообразное поведение для синтаксиса свойств и массивов.
     *
     * @see CoverArray::__isset()
     * @see CoverArray::offsetExists()
     */
    public function testIssetConsistencyWithOffsetExists(): void
    {
        $array = new NewTypeArray([
            'key' => 'value',
            'null_key' => null,
            'empty_string' => '',
            'zero' => 0,
            'false' => false,
            'array' => [],
            'object' => new stdClass(),
        ]);

        // 1. Для НЕ-null значений оба метода возвращают true
        // 1. For NON-null values both methods return true
        $this->assertTrue(isset($array->key));
        $this->assertTrue($array->offsetExists('key'));
        $this->assertTrue(isset($array['key']));

        $this->assertTrue(isset($array->empty_string));
        $this->assertTrue($array->offsetExists('empty_string'));
        $this->assertTrue(isset($array['empty_string']));

        $this->assertTrue(isset($array->zero));
        $this->assertTrue($array->offsetExists('zero'));
        $this->assertTrue(isset($array['zero']));

        $this->assertTrue(isset($array->false));
        $this->assertTrue($array->offsetExists('false'));
        $this->assertTrue(isset($array['false']));

        // 2. Для null значения оба метода возвращают false
        // 2. For null value both methods return false
        $this->assertFalse(isset($array->null_key));
        $this->assertFalse($array->offsetExists('null_key'));
        $this->assertFalse(isset($array['null_key']));

        // 3. Для несуществующего ключа оба метода возвращают false
        // 3. For non-existent key both methods return false
        $this->assertFalse(isset($array->non_existent));
        $this->assertFalse($array->offsetExists('non_existent'));
        $this->assertFalse(isset($array['non_existent']));

        // 4. Критическая проверка: идентичность результатов
        // 4. Critical check: results must be identical
        $this->assertSame(
            isset($array->null_key),
            isset($array['null_key']),
            'Доступ через свойство ($obj->key) и через массив ($obj[\'key\']) должны давать одинаковые результаты для null значений'
        );

        $this->assertSame(
            isset($array->key),
            isset($array['key']),
            'Доступ через свойство и через массив должны давать одинаковые результаты для не-null значений'
        );

        // 5. Дополнительные проверки для сложных типов
        // 5. Additional checks for complex types
        $this->assertTrue(isset($array->array));
        $this->assertTrue($array->offsetExists('array'));
        $this->assertTrue(isset($array['array']));

        $this->assertTrue(isset($array->object));
        $this->assertTrue($array->offsetExists('object'));
        $this->assertTrue(isset($array['object']));
    }
}