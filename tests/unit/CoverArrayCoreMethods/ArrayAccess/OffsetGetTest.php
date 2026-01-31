<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\ArrayAccess;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class OffsetGetTest extends TestCase
{
    /**
     * Tests offsetGet() with string keys using array syntax.
     *
     * This test verifies that the offsetGet() method correctly retrieves
     * values for existing string keys when using array syntax $array['key'].
     * Tests various data types including scalars, arrays, and objects.
     *
     *
     * Тестирование offsetGet() со строковыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что метод offsetGet() корректно извлекает
     * значения для существующих строковых ключей при использовании синтаксиса $array['key'].
     * Тестирует различные типы данных, включая скаляры, массивы и объекты.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithStringKeys(): void
    {
        $data = new NewTypeArray([
            'string' => 'Hello World',
            'integer' => 42,
            'float' => 3.14159,
            'boolean_true' => true,
            'boolean_false' => false,
            'null' => null,
            'empty_string' => '',
            'zero' => 0
        ]);

        // Test retrieving scalar values
        $this->assertSame('Hello World', $data['string']);
        $this->assertSame(42, $data['integer']);
        $this->assertSame(3.14159, $data['float']);
        $this->assertTrue($data['boolean_true']);
        $this->assertFalse($data['boolean_false']);
        $this->assertNull($data['null']);
        $this->assertSame('', $data['empty_string']);
        $this->assertSame(0, $data['zero']);

        // Direct method call should give same results
        $this->assertSame('Hello World', $data->offsetGet('string'));
        $this->assertSame(42, $data->offsetGet('integer'));
    }

    /**
     * Tests offsetGet() with numeric keys using array syntax.
     *
     * This test verifies that offsetGet() works correctly with numeric
     * indices, essential for using CoverArray as a list or sequential array.
     *
     *
     * Тестирование offsetGet() с числовыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что offsetGet() корректно работает с числовыми
     * индексами, что важно для использования CoverArray как списка или последовательного массива.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithNumericKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            5 => 'five',
            '10' => 'ten'
        ]);

        // Access by numeric index
        $this->assertSame('zero', $array[0]);
        $this->assertSame('one', $array[1]);
        $this->assertSame('two', $array[2]);
        $this->assertSame('five', $array[5]);
        $this->assertSame('ten', $array[10]);

        // Direct method call
        $this->assertSame('zero', $array->offsetGet(0));
        $this->assertSame('five', $array->offsetGet(5));

        // Sequential list
        $list = new NewTypeArray(['a', 'b', 'c', 'd']);
        $this->assertSame('a', $list[0]);
        $this->assertSame('b', $list[1]);
        $this->assertSame('c', $list[2]);
        $this->assertSame('d', $list[3]);
    }

    /**
     * Tests offsetGet() with non-existent keys returns null.
     *
     * This test ensures that accessing non-existent keys via offsetGet()
     * returns null instead of throwing an error, providing safe access
     * to potentially undefined elements.
     *
     *
     * Тестирование offsetGet() с несуществующими ключами возвращает null.
     *
     * Этот тест гарантирует, что доступ к несуществующим ключам через offsetGet()
     * возвращает null вместо выброса ошибки, обеспечивая безопасный доступ
     * к потенциально неопределенным элементам.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithNonExistentKeysReturnsNull(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);

        // Non-existent string keys should return null
        $this->assertNull($array['non_existent']);
        $this->assertNull($array['undefined']);
        $this->assertNull($array['missing']);

        // Non-existent numeric keys should return null
        $this->assertNull($array[0]);
        $this->assertNull($array[999]);
        $this->assertNull($array[-1]);

        // Direct method call
        $this->assertNull($array->offsetGet('non_existent'));
        $this->assertNull($array->offsetGet(123));
    }

    /**
     * Tests offsetGet() with nested array access.
     *
     * This test verifies that offsetGet() works correctly with nested
     * arrays, where nested plain arrays are automatically converted
     * to CoverArray instances.
     *
     *
     * Тестирование offsetGet() с доступом к вложенным массивам.
     *
     * Этот тест проверяет, что offsetGet() корректно работает с вложенными
     * массивами, где вложенные обычные массивы автоматически преобразуются
     * в экземпляры CoverArray.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithNestedArrays(): void
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
            'list' => [
                ['id' => 1, 'value' => 'first'],
                ['id' => 2, 'value' => 'second']
            ]
        ]);

        // Access nested structure
        $this->assertInstanceOf(NewTypeArray::class, $array['user']);
        $this->assertSame('John', $array['user']['name']);
        $this->assertSame(30, $array['user']['age']);

        // Access deeply nested
        $this->assertInstanceOf(NewTypeArray::class, $array['user']['profile']);
        $this->assertSame('Moscow', $array['user']['profile']['city']);
        $this->assertSame('Russia', $array['user']['profile']['country']);

        // Access array of arrays
        $this->assertInstanceOf(NewTypeArray::class, $array['list']);
        $this->assertInstanceOf(NewTypeArray::class, $array['list'][0]);
        $this->assertSame(1, $array['list'][0]['id']);
        $this->assertSame('first', $array['list'][0]['value']);
        $this->assertSame('second', $array['list'][1]['value']);
    }

    /**
     * Tests offsetGet() maintains object references.
     *
     * This test verifies that when objects are stored and retrieved via
     * offsetGet(), the same object reference is returned, not a copy.
     * This is important for maintaining object state consistency.
     *
     *
     * Тестирование offsetGet() сохраняет ссылки на объекты.
     *
     * Этот тест проверяет, что когда объекты сохраняются и извлекаются через
     * offsetGet(), возвращается та же ссылка на объект, а не копия.
     * Это важно для поддержания согласованности состояния объектов.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetMaintainsObjectReferences(): void
    {
        $originalObject = new stdClass();
        $originalObject->id = 'test-123';
        $originalObject->data = ['a', 'b', 'c'];

        $array = new NewTypeArray(['object' => $originalObject]);

        // Get the object back
        $retrievedObject = $array['object'];

        // Should be the same object (same reference)
        $this->assertSame($originalObject, $retrievedObject);

        // Modifying through retrieved reference should affect original
        $retrievedObject->modified = true;
        $this->assertTrue($originalObject->modified);

        // Test with nested objects
        $innerObject = new stdClass();
        $innerObject->value = 'inner';

        $array2 = new NewTypeArray([
            'nested' => [
                'object' => $innerObject
            ]
        ]);

        $retrievedInner = $array2['nested']['object'];
        $this->assertSame($innerObject, $retrievedInner);
    }

    /**
     * Tests offsetGet() with mixed key types.
     *
     * This test verifies that offsetGet() correctly handles arrays
     * with both numeric and string keys, a common PHP pattern.
     *
     *
     * Тестирование offsetGet() со смешанными типами ключей.
     *
     * Этот тест проверяет, что offsetGet() корректно обрабатывает массивы
     * с числовыми и строковыми ключами, что является распространенным паттерном PHP.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithMixedKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'first',
            'name' => 'John',
            1 => 'second',
            'age' => 30,
            2 => 'third'
        ]);

        // Access numeric keys
        $this->assertSame('first', $array[0]);
        $this->assertSame('second', $array[1]);
        $this->assertSame('third', $array[2]);

        // Access string keys
        $this->assertSame('John', $array['name']);
        $this->assertSame(30, $array['age']);

        // Verify all are accessible
        $this->assertCount(5, $array);
    }

    /**
     * Tests offsetGet() with special string keys.
     *
     * This test verifies that offsetGet() handles special characters
     * in keys correctly, including spaces, UTF-8, and special symbols.
     *
     *
     * Тестирование offsetGet() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что offsetGet() корректно обрабатывает специальные
     * символы в ключах, включая пробелы, UTF-8 и специальные символы.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray([
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'café' => 'coffee',
            'привет' => 'hello',
            '🎉' => 'party'
        ]);

        $this->assertSame('value1', $array['key with spaces']);
        $this->assertSame('value2', $array['key-with-dashes']);
        $this->assertSame('value3', $array['key.with.dots']);
        $this->assertSame('coffee', $array['café']);
        $this->assertSame('hello', $array['привет']);
        $this->assertSame('party', $array['🎉']);

        // Direct method calls
        $this->assertSame('coffee', $array->offsetGet('café'));
        $this->assertSame('hello', $array->offsetGet('привет'));
    }

    /**
     * Tests offsetGet() returns CoverArray for nested arrays.
     *
     * This test verifies that when retrieving an array value via offsetGet(),
     * it is automatically converted to a CoverArray instance, maintaining
     * the object-oriented interface throughout the structure.
     *
     *
     * Тестирование offsetGet() возвращает CoverArray для вложенных массивов.
     *
     * Этот тест проверяет, что при извлечении значения-массива через offsetGet(),
     * оно автоматически преобразуется в экземпляр CoverArray, сохраняя
     * объектно-ориентированный интерфейс во всей структуре.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetReturnsConvertsArraysToCoverArray(): void
    {
        $array = new NewTypeArray([
            'simple_array' => ['a', 'b', 'c'],
            'assoc_array' => ['key1' => 'value1', 'key2' => 'value2'],
            'empty_array' => [],
            'nested' => [
                'level1' => [
                    'level2' => 'deep'
                ]
            ]
        ]);

        // Simple array becomes CoverArray
        $simpleArray = $array['simple_array'];
        $this->assertInstanceOf(NewTypeArray::class, $simpleArray);
        $this->assertSame('a', $simpleArray[0]);
        $this->assertSame('b', $simpleArray[1]);

        // Associative array becomes CoverArray
        $assocArray = $array['assoc_array'];
        $this->assertInstanceOf(NewTypeArray::class, $assocArray);
        $this->assertSame('value1', $assocArray['key1']);

        // Empty array becomes empty CoverArray
        $emptyArray = $array['empty_array'];
        $this->assertInstanceOf(NewTypeArray::class, $emptyArray);
        $this->assertCount(0, $emptyArray);

        // Nested structure all converted
        $this->assertInstanceOf(NewTypeArray::class, $array['nested']);
        $this->assertInstanceOf(NewTypeArray::class, $array['nested']['level1']);
        $this->assertSame('deep', $array['nested']['level1']['level2']);
    }

    /**
     * Tests offsetGet() with edge cases.
     *
     * This test covers edge cases including zero values, empty strings,
     * resources, and callable functions to ensure offsetGet() handles
     * all PHP data types consistently.
     *
     *
     * Тестирование offsetGet() с граничными случаями.
     *
     * Этот тест охватывает граничные случаи, включая нулевые значения,
     * пустые строки, ресурсы и callable-функции, чтобы гарантировать,
     * что offsetGet() обрабатывает все типы данных PHP последовательно.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithEdgeCases(): void
    {
        // Zero values
        $data1 = new NewTypeArray([
            'zero_int' => 0,
            'zero_float' => 0.0,
            'empty_string' => '',
            'false_value' => false
        ]);

        $this->assertSame(0, $data1['zero_int']);
        $this->assertSame(0.0, $data1['zero_float']);
        $this->assertSame('', $data1['empty_string']);
        $this->assertFalse($data1['false_value']);

        // Resource
        $resource = fopen('php://memory', 'r');
        $data2 = new NewTypeArray(['resource' => $resource]);
        $this->assertSame($resource, $data2['resource']);
        $this->assertIsResource($data2['resource']);
        fclose($resource);

        // Callable
        $callable = fn() => 'test';
        $data3 = new NewTypeArray(['callable' => $callable]);
        $this->assertSame($callable, $data3['callable']);
        $this->assertIsCallable($data3['callable']);
    }

    /**
     * Tests offsetGet() performance with large datasets.
     *
     * This test verifies that offsetGet() works efficiently even with
     * large numbers of elements, ensuring scalability.
     *
     *
     * Тестирование производительности offsetGet() с большими наборами данных.
     *
     * Этот тест проверяет, что offsetGet() работает эффективно даже с
     * большим количеством элементов, обеспечивая масштабируемость.
     *
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetWithLargeDataset(): void
    {
        // Create a large dataset
        $largeArray = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeArray["key_$i"] = "value_$i";
        }

        $array = new NewTypeArray($largeArray);

        // Test random access
        $this->assertSame('value_42', $array['key_42']);
        $this->assertSame('value_999', $array['key_999']);
        $this->assertSame('value_0', $array['key_0']);

        // Test non-existent in large dataset
        $this->assertNull($array['non_existent_key']);

        // Test with numeric indices
        $largeList = new NewTypeArray(range(0, 999));
        $this->assertSame(42, $largeList[42]);
        $this->assertSame(999, $largeList[999]);
    }

    /**
     * Tests offsetGet() after modifications.
     *
     * This test verifies that offsetGet() correctly retrieves values
     * after the array has been modified through various operations.
     *
     *
     * Тестирование offsetGet() после модификаций.
     *
     * Этот тест проверяет, что offsetGet() корректно извлекает значения
     * после модификации массива через различные операции.
     *
     * @see CoverArray::offsetGet()
     * @see CoverArray::offsetSet()
     * @see CoverArray::offsetUnset()
     */
    public function testOffsetGetAfterModifications(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        // Initial value
        $this->assertSame('value', $array['initial']);

        // After modification
        $array['initial'] = 'modified';
        $this->assertSame('modified', $array['initial']);

        // After adding new key
        $array['new'] = 'new_value';
        $this->assertSame('new_value', $array['new']);

        // After removal
        unset($array['initial']);
        $this->assertNull($array['initial']);

        // Existing key still works
        $this->assertSame('new_value', $array['new']);
    }
}
