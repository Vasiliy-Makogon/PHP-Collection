<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\ArrayAccess;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class OffsetUnsetTest extends TestCase
{
    /**
     * Tests offsetUnset() with string keys using array syntax.
     *
     * This test verifies that the offsetUnset() method correctly removes
     * elements when using array syntax unset($array['key']).
     * Tests removal of various data types.
     *
     *
     * Тестирование offsetUnset() со строковыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что метод offsetUnset() корректно удаляет
     * элементы при использовании синтаксиса массива unset($array['key']).
     * Тестирует удаление различных типов данных.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithStringKeys(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool' => true,
            'null' => null,
            'array' => [1, 2, 3],
            'object' => new stdClass()
        ]);

        $initialCount = count($array);

        // Remove string key
        unset($array['string']);
        $this->assertFalse(isset($array['string']));
        $this->assertNull($array['string']);

        // Remove integer value
        unset($array['int']);
        $this->assertFalse(isset($array['int']));

        // Remove array value
        unset($array['array']);
        $this->assertFalse(isset($array['array']));

        // Remove object value
        unset($array['object']);
        $this->assertFalse(isset($array['object']));

        // Verify remaining keys exist
        $this->assertTrue(isset($array['float']));
        $this->assertTrue(isset($array['bool']));

        // Verify count decreased
        $this->assertCount($initialCount - 4, $array);
    }

    /**
     * Tests offsetUnset() with numeric keys using array syntax.
     *
     * This test verifies that offsetUnset() works correctly with numeric
     * indices, essential for list-like usage of CoverArray.
     *
     *
     * Тестирование offsetUnset() с числовыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что offsetUnset() корректно работает с числовыми
     * индексами, что важно для использования CoverArray как списка.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithNumericKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            5 => 'five'
        ]);

        // Remove numeric indices
        unset($array[0]);
        unset($array[2]);
        unset($array[5]);

        $this->assertFalse(isset($array[0]));
        $this->assertFalse(isset($array[2]));
        $this->assertFalse(isset($array[5]));

        // Remaining indices should still exist
        $this->assertTrue(isset($array[1]));
        $this->assertTrue(isset($array[3]));
        $this->assertSame('one', $array[1]);
        $this->assertSame('three', $array[3]);

        $this->assertCount(2, $array);

        // Direct method call
        $array->offsetUnset(1);
        $this->assertFalse(isset($array[1]));
        $this->assertCount(1, $array);
    }

    /**
     * Tests offsetUnset() with non-existent keys.
     *
     * This test verifies that attempting to unset non-existent keys
     * does not throw errors and handles the operation gracefully.
     *
     *
     * Тестирование offsetUnset() с несуществующими ключами.
     *
     * Этот тест проверяет, что попытка удалить несуществующие ключи
     * не вызывает ошибок и корректно обрабатывается.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithNonExistentKeys(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);

        $initialCount = count($array);

        // Unset non-existent string keys (should not error)
        unset($array['non_existent']);
        unset($array['undefined']);
        unset($array['missing']);

        // Unset non-existent numeric keys
        unset($array[0]);
        unset($array[999]);
        unset($array[-1]);

        // Count should remain the same
        $this->assertCount($initialCount, $array);

        // Existing key should still work
        $this->assertTrue(isset($array['existing']));
        $this->assertSame('value', $array['existing']);

        // Direct method call with non-existent key
        $array->offsetUnset('another_non_existent');
        $this->assertCount($initialCount, $array);
    }

    /**
     * Tests offsetUnset() preserves other keys.
     *
     * This test ensures that unsetting one key does not affect
     * other keys in the array and that data types are preserved.
     *
     *
     * Тестирование offsetUnset() сохраняет другие ключи.
     *
     * Этот тест гарантирует, что удаление одного ключа не влияет
     * на другие ключи в массиве и что типы данных сохраняются.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetPreservesOtherKeys(): void
    {
        $object = new stdClass();
        $object->id = 42;

        $array = new NewTypeArray([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'int' => 100,
            'float' => 3.14,
            'bool' => true,
            'array' => [1, 2, 3],
            'object' => $object
        ]);

        $originalObject = $array['object'];

        // Remove some keys
        unset($array['key2']);
        unset($array['int']);
        unset($array['array']);

        // Verify removed keys are gone
        $this->assertFalse(isset($array['key2']));
        $this->assertFalse(isset($array['int']));
        $this->assertFalse(isset($array['array']));

        // Verify remaining keys exist with correct values
        $this->assertSame('value1', $array['key1']);
        $this->assertSame('value3', $array['key3']);
        $this->assertSame(3.14, $array['float']);
        $this->assertTrue($array['bool']);
        $this->assertSame($originalObject, $array['object']);

        // Verify types are preserved
        $this->assertIsFloat($array['float']);
        $this->assertIsBool($array['bool']);
        $this->assertInstanceOf(stdClass::class, $array['object']);

        $this->assertCount(5, $array);
    }

    /**
     * Tests offsetUnset() with mixed key types.
     *
     * This test verifies that offsetUnset() correctly handles removal
     * of both numeric and string keys from the same array.
     *
     *
     * Тестирование offsetUnset() со смешанными типами ключей.
     *
     * Этот тест проверяет, что offsetUnset() корректно обрабатывает удаление
     * числовых и строковых ключей из одного массива.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithMixedKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'first',
            'name' => 'John',
            1 => 'second',
            'age' => 30,
            2 => 'third',
            'active' => true
        ]);

        // Remove numeric keys
        unset($array[0]);
        unset($array[2]);

        // Remove string keys
        unset($array['name']);
        unset($array['active']);

        // Check removed keys
        $this->assertFalse(isset($array[0]));
        $this->assertFalse(isset($array[2]));
        $this->assertFalse(isset($array['name']));
        $this->assertFalse(isset($array['active']));

        // Check remaining keys
        $this->assertTrue(isset($array[1]));
        $this->assertTrue(isset($array['age']));
        $this->assertSame('second', $array[1]);
        $this->assertSame(30, $array['age']);

        $this->assertCount(2, $array);
    }

    /**
     * Tests offsetUnset() with special string keys.
     *
     * This test verifies that offsetUnset() handles special characters
     * in keys correctly, including spaces, UTF-8, and special symbols.
     *
     *
     * Тестирование offsetUnset() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что offsetUnset() корректно обрабатывает специальные
     * символы в ключах, включая пробелы, UTF-8 и специальные символы.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray([
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'café' => 'coffee',
            'привет' => 'hello',
            '🎉' => 'party'
        ]);

        unset($array['key with spaces']);
        unset($array['café']);
        unset($array['🎉']);

        $this->assertFalse(isset($array['key with spaces']));
        $this->assertFalse(isset($array['café']));
        $this->assertFalse(isset($array['🎉']));

        $this->assertTrue(isset($array['key-with-dashes']));
        $this->assertTrue(isset($array['key.with.dots']));
        $this->assertTrue(isset($array['привет']));

        // Direct method calls
        $array->offsetUnset('key-with-dashes');
        $this->assertFalse(isset($array['key-with-dashes']));

        $this->assertCount(2, $array);
    }

    /**
     * Tests offsetUnset() with nested arrays.
     *
     * This test verifies that offsetUnset() works correctly with
     * nested structures, removing elements at various nesting levels.
     *
     *
     * Тестирование offsetUnset() с вложенными массивами.
     *
     * Этот тест проверяет, что offsetUnset() корректно работает с
     * вложенными структурами, удаляя элементы на различных уровнях вложенности.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithNestedArrays(): void
    {
        $array = new NewTypeArray([
            'user' => [
                'name' => 'John',
                'age' => 30,
                'profile' => [
                    'city' => 'Moscow',
                    'country' => 'Russia'
                ]
            ],
            'settings' => [
                'theme' => 'dark',
                'notifications' => true
            ]
        ]);

        // Remove nested property
        unset($array['user']['age']);
        $this->assertFalse(isset($array['user']['age']));
        $this->assertTrue(isset($array['user']['name']));

        // Remove deeply nested property
        unset($array['user']['profile']['city']);
        $this->assertFalse(isset($array['user']['profile']['city']));
        $this->assertTrue(isset($array['user']['profile']['country']));

        // Remove entire nested structure
        unset($array['settings']);
        $this->assertFalse(isset($array['settings']));
        $this->assertTrue(isset($array['user']));

        // Remove remaining nested property
        unset($array['user']['profile']);
        $this->assertFalse(isset($array['user']['profile']));
        $this->assertTrue(isset($array['user']['name']));
    }

    /**
     * Tests offsetUnset() after various modifications.
     *
     * This test verifies that offsetUnset() works correctly after
     * the array has been modified through various operations.
     *
     *
     * Тестирование offsetUnset() после различных модификаций.
     *
     * Этот тест проверяет, что offsetUnset() корректно работает после
     * модификации массива через различные операции.
     *
     * @see CoverArray::offsetUnset()
     * @see CoverArray::offsetSet()
     */
    public function testOffsetUnsetAfterModifications(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        // Add new keys
        $array['dynamic1'] = 'value1';
        $array['dynamic2'] = 'value2';
        $array[0] = 'zero';

        $this->assertCount(4, $array);

        // Remove newly added keys
        unset($array['dynamic1']);
        $this->assertFalse(isset($array['dynamic1']));
        $this->assertCount(3, $array);

        // Modify and then remove
        $array['dynamic2'] = 'modified';
        unset($array['dynamic2']);
        $this->assertFalse(isset($array['dynamic2']));

        // Remove numeric key
        unset($array[0]);
        $this->assertFalse(isset($array[0]));

        // Only initial key should remain
        $this->assertCount(1, $array);
        $this->assertTrue(isset($array['initial']));
        $this->assertSame('value', $array['initial']);
    }

    /**
     * Tests offsetUnset() with all value types.
     *
     * This test ensures that offsetUnset() correctly removes
     * keys regardless of their value types, including null,
     * false, empty strings, and zero.
     *
     *
     * Тестирование offsetUnset() со всеми типами значений.
     *
     * Этот тест гарантирует, что offsetUnset() корректно удаляет
     * ключи независимо от их типов значений, включая null,
     * false, пустые строки и ноль.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithAllValueTypes(): void
    {
        $array = new NewTypeArray([
            'null' => null,
            'false' => false,
            'true' => true,
            'zero' => 0,
            'empty_string' => '',
            'zero_float' => 0.0,
            'empty_array' => [],
            'filled_array' => [1, 2, 3],
            'object' => new stdClass(),
            'cover' => new NewTypeArray(['nested' => 'value'])
        ]);

        // Remove null value (note: null values don't count in isset/count)
        unset($array['null']);
        $this->assertFalse(isset($array['null']));

        // Remove false value
        unset($array['false']);
        $this->assertFalse(isset($array['false']));

        // Remove zero values
        unset($array['zero']);
        unset($array['zero_float']);
        $this->assertFalse(isset($array['zero']));
        $this->assertFalse(isset($array['zero_float']));

        // Remove empty values
        unset($array['empty_string']);
        unset($array['empty_array']);
        $this->assertFalse(isset($array['empty_string']));
        $this->assertFalse(isset($array['empty_array']));

        // Verify remaining keys
        $this->assertTrue(isset($array['true']));
        $this->assertTrue(isset($array['filled_array']));
        $this->assertTrue(isset($array['object']));
        $this->assertTrue(isset($array['cover']));

        // Should have 4 remaining elements (true, filled_array, object, cover)
        // Note: null doesn't count in count() since isset() returns false for null values
        $this->assertCount(4, $array);
    }

    /**
     * Tests offsetUnset() does not modify object references.
     *
     * This test verifies that unsetting a key that contains an object
     * does not modify the object itself, only removes it from the array.
     *
     *
     * Тестирование offsetUnset() не изменяет ссылки на объекты.
     *
     * Этот тест проверяет, что удаление ключа, содержащего объект,
     * не изменяет сам объект, а только удаляет его из массива.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetDoesNotModifyObjects(): void
    {
        $object = new stdClass();
        $object->id = 'test-123';
        $object->data = ['a', 'b', 'c'];

        $array = new NewTypeArray([
            'obj1' => $object,
            'obj2' => $object
        ]);

        // Keep reference before unsetting
        $reference = $array['obj1'];

        // Unset one key
        unset($array['obj1']);

        // Object should still exist via other key
        $this->assertSame($object, $array['obj2']);

        // Original object should be unchanged
        $this->assertSame('test-123', $object->id);
        $this->assertSame(['a', 'b', 'c'], $object->data);

        // Reference kept before unsetting should still be valid
        $this->assertSame($object, $reference);
    }

    /**
     * Tests offsetUnset() with large dataset.
     *
     * This test verifies that offsetUnset() works efficiently
     * even with large numbers of elements.
     *
     *
     * Тестирование offsetUnset() с большим набором данных.
     *
     * Этот тест проверяет, что offsetUnset() работает эффективно
     * даже с большим количеством элементов.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetWithLargeDataset(): void
    {
        // Create large array
        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data["key_$i"] = "value_$i";
        }

        $array = new NewTypeArray($data);
        $this->assertCount(1000, $array);

        // Remove many elements
        for ($i = 0; $i < 500; $i++) {
            unset($array["key_$i"]);
        }

        $this->assertCount(500, $array);

        // Verify removed elements are gone
        $this->assertFalse(isset($array['key_0']));
        $this->assertFalse(isset($array['key_42']));
        $this->assertFalse(isset($array['key_499']));

        // Verify remaining elements exist
        $this->assertTrue(isset($array['key_500']));
        $this->assertTrue(isset($array['key_999']));
        $this->assertSame('value_999', $array['key_999']);
    }

    /**
     * Tests offsetUnset() multiple times on same key.
     *
     * This test verifies that calling offsetUnset() multiple times
     * on the same key does not cause errors or unexpected behavior.
     *
     *
     * Тестирование offsetUnset() несколько раз на одном ключе.
     *
     * Этот тест проверяет, что вызов offsetUnset() несколько раз
     * на одном ключе не вызывает ошибок или неожиданного поведения.
     *
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetUnsetMultipleTimesOnSameKey(): void
    {
        $array = new NewTypeArray(['key' => 'value']);

        $this->assertTrue(isset($array['key']));
        $this->assertCount(1, $array);

        // First unset
        unset($array['key']);
        $this->assertFalse(isset($array['key']));
        $this->assertCount(0, $array);

        // Second unset on same key (should not error)
        unset($array['key']);
        $this->assertFalse(isset($array['key']));
        $this->assertCount(0, $array);

        // Third unset (still should not error)
        $array->offsetUnset('key');
        $this->assertCount(0, $array);
    }
}
