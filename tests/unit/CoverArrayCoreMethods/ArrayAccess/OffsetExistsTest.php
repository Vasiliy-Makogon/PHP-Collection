<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\ArrayAccess;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class OffsetExistsTest extends TestCase
{
    /**
     * Tests offsetExists() with string keys using array syntax.
     *
     * This test verifies that the offsetExists() method correctly identifies
     * the existence of keys when accessed using array syntax isset($array['key']).
     * It tests various scalar values including falsy values that should still
     * return true when they exist.
     *
     *
     * Тестирование offsetExists() со строковыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что метод offsetExists() корректно определяет
     * существование ключей при доступе через синтаксис массива isset($array['key']).
     * Он тестирует различные скалярные значения, включая "ложные" значения,
     * которые должны возвращать true, когда они существуют.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithStringKeys(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'zero' => 0,
            'empty_string' => '',
            'array' => [1, 2, 3]
        ]);

        // Existing keys with non-null values should return true
        $this->assertTrue(isset($array['string']));
        $this->assertTrue(isset($array['int']));
        $this->assertTrue(isset($array['float']));
        $this->assertTrue(isset($array['bool_true']));
        $this->assertTrue(isset($array['bool_false']));
        $this->assertTrue(isset($array['zero']));
        $this->assertTrue(isset($array['empty_string']));
        $this->assertTrue(isset($array['array']));

        // Direct method call should give same results
        $this->assertTrue($array->offsetExists('string'));
        $this->assertTrue($array->offsetExists('int'));
        $this->assertTrue($array->offsetExists('float'));
    }

    /**
     * Tests offsetExists() with numeric keys using array syntax.
     *
     * This test verifies that offsetExists() works correctly with numeric
     * indices, which is essential for using CoverArray as a list.
     * Tests both integer and string numeric keys.
     *
     *
     * Тестирование offsetExists() с числовыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что offsetExists() корректно работает с числовыми
     * индексами, что важно для использования CoverArray как списка.
     * Тестирует как целочисленные, так и строковые числовые ключи.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithNumericKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            5 => 'five',  // Gap in indices
            '10' => 'ten'  // String numeric key
        ]);

        // Check numeric indices
        $this->assertTrue(isset($array[0]));
        $this->assertTrue(isset($array[1]));
        $this->assertTrue(isset($array[2]));
        $this->assertTrue(isset($array[5]));
        $this->assertTrue(isset($array['10']));
        $this->assertTrue(isset($array[10])); // PHP converts string to int

        // Check missing indices
        $this->assertFalse(isset($array[3]));
        $this->assertFalse(isset($array[4]));
        $this->assertFalse(isset($array[6]));

        // Direct method call
        $this->assertTrue($array->offsetExists(0));
        $this->assertTrue($array->offsetExists(1));
        $this->assertFalse($array->offsetExists(3));
    }

    /**
     * Tests offsetExists() with null values.
     *
     * This test ensures that offsetExists() returns false for keys
     * that exist but have null values, which is consistent with PHP's
     * standard isset() behavior.
     *
     *
     * Тестирование offsetExists() со значениями null.
     *
     * Этот тест гарантирует, что offsetExists() возвращает false для ключей,
     * которые существуют, но имеют значения null, что согласуется со
     * стандартным поведением isset() в PHP.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithNullValues(): void
    {
        $array = new NewTypeArray([
            'null_value' => null,
            'explicit_null' => null,
            'not_null' => 'value'
        ]);

        // Keys with null values should return false
        $this->assertFalse(isset($array['null_value']));
        $this->assertFalse(isset($array['explicit_null']));
        $this->assertFalse($array->offsetExists('null_value'));
        $this->assertFalse($array->offsetExists('explicit_null'));

        // Non-null value should return true
        $this->assertTrue(isset($array['not_null']));
        $this->assertTrue($array->offsetExists('not_null'));

        // After setting to null
        $array['not_null'] = null;
        $this->assertFalse(isset($array['not_null']));
        $this->assertFalse($array->offsetExists('not_null'));
    }

    /**
     * Tests offsetExists() with non-existent keys.
     *
     * This test verifies that offsetExists() returns false for keys
     * that do not exist in the array, preventing errors when checking
     * for undefined elements.
     *
     *
     * Тестирование offsetExists() с несуществующими ключами.
     *
     * Этот тест проверяет, что offsetExists() возвращает false для ключей,
     * которые не существуют в массиве, предотвращая ошибки при проверке
     * неопределенных элементов.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithNonExistentKeys(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);

        // Non-existent string keys
        $this->assertFalse(isset($array['non_existent']));
        $this->assertFalse(isset($array['undefined']));
        $this->assertFalse(isset($array['missing_key']));

        // Non-existent numeric keys
        $this->assertFalse(isset($array[0]));
        $this->assertFalse(isset($array[123]));
        $this->assertFalse(isset($array[-1]));

        // Direct method calls
        $this->assertFalse($array->offsetExists('non_existent'));
        $this->assertFalse($array->offsetExists(0));
        $this->assertFalse($array->offsetExists(999));

        // Existing key should still work
        $this->assertTrue(isset($array['existing']));
        $this->assertTrue($array->offsetExists('existing'));
    }

    /**
     * Tests offsetExists() with mixed key types.
     *
     * This test verifies that offsetExists() handles arrays with both
     * numeric and string keys correctly, which is a common pattern
     * in PHP arrays.
     *
     *
     * Тестирование offsetExists() со смешанными типами ключей.
     *
     * Этот тест проверяет, что offsetExists() корректно обрабатывает массивы
     * с числовыми и строковыми ключами, что является распространенным
     * паттерном в PHP массивах.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithMixedKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'first',
            'name' => 'John',
            1 => 'second',
            'age' => 30,
            2 => 'third',
            'active' => true
        ]);

        // Check numeric keys
        $this->assertTrue(isset($array[0]));
        $this->assertTrue(isset($array[1]));
        $this->assertTrue(isset($array[2]));

        // Check string keys
        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['age']));
        $this->assertTrue(isset($array['active']));

        // Check non-existent keys
        $this->assertFalse(isset($array[3]));
        $this->assertFalse(isset($array['email']));

        // Verify count
        $this->assertCount(6, $array);
    }

    /**
     * Tests offsetExists() with nested arrays.
     *
     * This test verifies that offsetExists() works correctly with
     * nested array access, where nested arrays are converted to
     * CoverArray instances.
     *
     *
     * Тестирование offsetExists() с вложенными массивами.
     *
     * Этот тест проверяет, что offsetExists() корректно работает с
     * доступом к вложенным массивам, где вложенные массивы преобразуются
     * в экземпляры CoverArray.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithNestedArrays(): void
    {
        $array = new NewTypeArray([
            'user' => [
                'name' => 'John',
                'profile' => [
                    'age' => 30,
                    'city' => 'Moscow'
                ]
            ],
            'settings' => []
        ]);

        // Check top level
        $this->assertTrue(isset($array['user']));
        $this->assertTrue(isset($array['settings']));

        // Check nested level
        $this->assertTrue(isset($array['user']['name']));
        $this->assertTrue(isset($array['user']['profile']));

        // Check deeply nested
        $this->assertTrue(isset($array['user']['profile']['age']));
        $this->assertTrue(isset($array['user']['profile']['city']));

        // Check non-existent in nested
        $this->assertFalse(isset($array['user']['email']));
        $this->assertFalse(isset($array['user']['profile']['country']));

        // Empty array should exist
        $this->assertTrue(isset($array['settings']));
    }

    /**
     * Tests offsetExists() with special string keys.
     *
     * This test verifies that offsetExists() handles special string
     * keys correctly, including keys with spaces, special characters,
     * and unusual naming patterns.
     *
     *
     * Тестирование offsetExists() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что offsetExists() корректно обрабатывает
     * специальные строковые ключи, включая ключи с пробелами,
     * специальными символами и необычными шаблонами именования.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray([
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'key_with_underscores' => 'value4',
            'CamelCaseKey' => 'value5',
            '123numericStart' => 'value6',
            'café' => 'value7',
            'привет' => 'value8'
        ]);

        $this->assertTrue(isset($array['key with spaces']));
        $this->assertTrue(isset($array['key-with-dashes']));
        $this->assertTrue(isset($array['key.with.dots']));
        $this->assertTrue(isset($array['key_with_underscores']));
        $this->assertTrue(isset($array['CamelCaseKey']));
        $this->assertTrue(isset($array['123numericStart']));
        $this->assertTrue(isset($array['café']));
        $this->assertTrue(isset($array['привет']));

        // Direct method calls
        $this->assertTrue($array->offsetExists('key with spaces'));
        $this->assertTrue($array->offsetExists('café'));
        $this->assertTrue($array->offsetExists('привет'));
    }

    /**
     * Tests offsetExists() with objects.
     *
     * This test ensures that offsetExists() correctly identifies
     * keys that have object values, returning true even if the object
     * itself might be considered "empty" in other contexts.
     *
     *
     * Тестирование offsetExists() с объектами.
     *
     * Этот тест гарантирует, что offsetExists() корректно определяет
     * ключи, имеющие объектные значения, возвращая true, даже если
     * сам объект может считаться "пустым" в других контекстах.
     *
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsWithObjects(): void
    {
        $object = new stdClass();
        $object->property = 'value';

        $array = new NewTypeArray([
            'object' => $object,
            'empty_object' => new stdClass(),
            'cover_array' => new NewTypeArray(),
            'nested_cover' => new NewTypeArray(['key' => 'value'])
        ]);

        $this->assertTrue(isset($array['object']));
        $this->assertTrue(isset($array['empty_object']));
        $this->assertTrue(isset($array['cover_array']));
        $this->assertTrue(isset($array['nested_cover']));

        // Direct method calls
        $this->assertTrue($array->offsetExists('object'));
        $this->assertTrue($array->offsetExists('empty_object'));
        $this->assertTrue($array->offsetExists('cover_array'));
    }

    /**
     * Tests offsetExists() after modifications.
     *
     * This test verifies that offsetExists() correctly reflects changes
     * to the array after elements are added, modified, or removed.
     *
     *
     * Тестирование offsetExists() после модификаций.
     *
     * Этот тест проверяет, что offsetExists() корректно отражает изменения
     * в массиве после добавления, изменения или удаления элементов.
     *
     * @see CoverArray::offsetExists()
     * @see CoverArray::offsetSet()
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetExistsAfterModifications(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        // Initial state
        $this->assertTrue(isset($array['initial']));
        $this->assertFalse(isset($array['dynamic']));

        // Add new key
        $array['dynamic'] = 'new_value';
        $this->assertTrue(isset($array['dynamic']));

        // Modify existing key
        $array['initial'] = 'modified';
        $this->assertTrue(isset($array['initial']));

        // Set to null
        $array['dynamic'] = null;
        $this->assertFalse(isset($array['dynamic'])); // null values return false

        // Remove key
        unset($array['initial']);
        $this->assertFalse(isset($array['initial']));

        // Add numeric key
        $array[0] = 'first';
        $this->assertTrue(isset($array[0]));

        // Remove numeric key
        unset($array[0]);
        $this->assertFalse(isset($array[0]));
    }
}
