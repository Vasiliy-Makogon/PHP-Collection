<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\ArrayAccess;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use DateTime;

#[CoversClass(CoverArray::class)]
class OffsetSetTest extends TestCase
{
    /**
     * Tests offsetSet() with string keys using array syntax.
     *
     * This test verifies that the offsetSet() method correctly stores
     * values for string keys when using array syntax $array['key'] = $value.
     * Tests various scalar data types.
     *
     *
     * Тестирование offsetSet() со строковыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что метод offsetSet() корректно сохраняет
     * значения для строковых ключей при использовании синтаксиса $array['key'] = $value.
     * Тестирует различные скалярные типы данных.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithStringKeys(): void
    {
        $array = new NewTypeArray();

        // Set string values
        $array['string'] = 'Hello World';
        $this->assertSame('Hello World', $array['string']);

        // Set integer values
        $array['integer'] = 42;
        $this->assertSame(42, $array['integer']);

        // Set float values
        $array['float'] = 3.14159;
        $this->assertSame(3.14159, $array['float']);

        // Set boolean values
        $array['bool_true'] = true;
        $array['bool_false'] = false;
        $this->assertTrue($array['bool_true']);
        $this->assertFalse($array['bool_false']);

        // Set null value
        $array['null_value'] = null;
        $this->assertNull($array['null_value']);

        // Set zero and empty values
        $array['zero'] = 0;
        $array['empty_string'] = '';
        $this->assertSame(0, $array['zero']);
        $this->assertSame('', $array['empty_string']);
    }

    /**
     * Tests offsetSet() with numeric keys using array syntax.
     *
     * This test verifies that offsetSet() works correctly with numeric
     * indices, essential for using CoverArray as a list or sequential array.
     *
     *
     * Тестирование offsetSet() с числовыми ключами через синтаксис массива.
     *
     * Этот тест проверяет, что offsetSet() корректно работает с числовыми
     * индексами, что важно для использования CoverArray как списка или последовательного массива.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithNumericKeys(): void
    {
        $array = new NewTypeArray();

        // Set numeric indices
        $array[0] = 'zero';
        $array[1] = 'one';
        $array[2] = 'two';

        $this->assertSame('zero', $array[0]);
        $this->assertSame('one', $array[1]);
        $this->assertSame('two', $array[2]);

        // Set with gaps
        $array[5] = 'five';
        $this->assertSame('five', $array[5]);
        $this->assertNull($array[3]);
        $this->assertNull($array[4]);

        // String numeric keys
        $array['10'] = 'ten';
        $this->assertSame('ten', $array[10]);

        // Direct method call
        $array->offsetSet(99, 'ninety-nine');
        $this->assertSame('ninety-nine', $array[99]);
    }

    /**
     * Tests offsetSet() append with null offset.
     *
     * This test verifies that using $array[] = $value (null offset)
     * correctly appends the value to the array with the next numeric index.
     *
     *
     * Тестирование offsetSet() добавление с null offset.
     *
     * Этот тест проверяет, что использование $array[] = $value (null offset)
     * корректно добавляет значение в массив со следующим числовым индексом.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetAppendWithNullOffset(): void
    {
        $array = new NewTypeArray();

        // Append to empty array
        $array[] = 'first';
        $this->assertSame('first', $array[0]);

        // Append more values
        $array[] = 'second';
        $array[] = 'third';
        $this->assertSame('second', $array[1]);
        $this->assertSame('third', $array[2]);

        // Append with existing numeric keys
        $array[5] = 'five';
        $array[] = 'six'; // Should get index 6
        $this->assertSame('six', $array[6]);

        // Direct method call with null
        $array->offsetSet(null, 'seven');
        $this->assertSame('seven', $array[7]);

        $this->assertCount(6, $array); // 0,1,2,5,6,7
    }

    /**
     * Tests offsetSet() overwrites existing values.
     *
     * This test verifies that setting a value for an existing key
     * correctly overwrites the previous value.
     *
     *
     * Тестирование offsetSet() перезаписывает существующие значения.
     *
     * Этот тест проверяет, что установка значения для существующего ключа
     * корректно перезаписывает предыдущее значение.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetOverwritesExistingValues(): void
    {
        $array = new NewTypeArray(['key' => 'original']);

        // Overwrite with new value
        $this->assertSame('original', $array['key']);
        $array['key'] = 'modified';
        $this->assertSame('modified', $array['key']);

        // Overwrite scalar with array
        $array['scalar'] = 'string';
        $array['scalar'] = ['a', 'b', 'c'];
        $this->assertInstanceOf(NewTypeArray::class, $array['scalar']);
        $this->assertSame(['a', 'b', 'c'], $array['scalar']->getDataAsArray());

        // Overwrite array with scalar
        $array['array_key'] = ['x', 'y'];
        $array['array_key'] = 123;
        $this->assertSame(123, $array['array_key']);

        // Multiple overwrites
        $array[0] = 'first';
        $array[0] = 'second';
        $array[0] = 'third';
        $this->assertSame('third', $array[0]);
    }

    /**
     * Tests offsetSet() converts arrays to CoverArray.
     *
     * This test verifies that when an array is assigned via offsetSet(),
     * it is automatically converted to a CoverArray instance, maintaining
     * the object-oriented interface.
     *
     *
     * Тестирование offsetSet() преобразует массивы в CoverArray.
     *
     * Этот тест проверяет, что когда массив присваивается через offsetSet(),
     * он автоматически преобразуется в экземпляр CoverArray, сохраняя
     * объектно-ориентированный интерфейс.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetConvertsArraysToCoverArray(): void
    {
        $array = new NewTypeArray();

        // Simple array conversion
        $array['simple'] = ['a', 'b', 'c'];
        $this->assertInstanceOf(NewTypeArray::class, $array['simple']);
        $this->assertSame('a', $array['simple'][0]);

        // Associative array conversion
        $array['assoc'] = ['name' => 'John', 'age' => 30];
        $this->assertInstanceOf(NewTypeArray::class, $array['assoc']);
        $this->assertSame('John', $array['assoc']['name']);

        // Empty array conversion
        $array['empty'] = [];
        $this->assertInstanceOf(NewTypeArray::class, $array['empty']);
        $this->assertCount(0, $array['empty']);

        // Nested arrays
        $array['nested'] = [
            'level1' => [
                'level2' => ['deep' => 'value']
            ]
        ];
        $this->assertInstanceOf(NewTypeArray::class, $array['nested']);
        $this->assertInstanceOf(NewTypeArray::class, $array['nested']['level1']);
        $this->assertInstanceOf(NewTypeArray::class, $array['nested']['level1']['level2']);
        $this->assertSame('value', $array['nested']['level1']['level2']['deep']);
    }

    /**
     * Tests offsetSet() with object values.
     *
     * This test verifies that non-CoverArray objects are stored as-is
     * without modification, maintaining object references.
     *
     *
     * Тестирование offsetSet() с объектными значениями.
     *
     * Этот тест проверяет, что объекты, не являющиеся CoverArray, сохраняются
     * как есть без изменений, сохраняя ссылки на объекты.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithObjectValues(): void
    {
        $array = new NewTypeArray();

        // Standard PHP objects
        $stdObject = new stdClass();
        $stdObject->property = 'value';
        $array['object'] = $stdObject;

        $this->assertSame($stdObject, $array['object']);
        $this->assertSame('value', $array['object']->property);

        // DateTime objects
        $dateTime = new DateTime('2023-01-01');
        $array['datetime'] = $dateTime;

        $this->assertSame($dateTime, $array['datetime']);
        $this->assertSame('2023-01-01', $array['datetime']->format('Y-m-d'));

        // CoverArray instances preserved
        $coverArray = new NewTypeArray(['inner' => 'value']);
        $array['cover'] = $coverArray;

        $this->assertSame($coverArray, $array['cover']);
        $this->assertSame('value', $array['cover']['inner']);
    }

    /**
     * Tests offsetSet() with mixed key types.
     *
     * This test verifies that offsetSet() correctly handles setting
     * values for both numeric and string keys in the same array.
     *
     *
     * Тестирование offsetSet() со смешанными типами ключей.
     *
     * Этот тест проверяет, что offsetSet() корректно обрабатывает установку
     * значений для числовых и строковых ключей в одном массиве.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithMixedKeys(): void
    {
        $array = new NewTypeArray();

        // Mix numeric and string keys
        $array[0] = 'first';
        $array['name'] = 'John';
        $array[1] = 'second';
        $array['age'] = 30;
        $array[2] = 'third';

        $this->assertSame('first', $array[0]);
        $this->assertSame('John', $array['name']);
        $this->assertSame('second', $array[1]);
        $this->assertSame(30, $array['age']);
        $this->assertSame('third', $array[2]);

        $this->assertCount(5, $array);
    }

    /**
     * Tests offsetSet() with special string keys.
     *
     * This test verifies that offsetSet() handles special characters
     * in keys correctly, including spaces, UTF-8, and special symbols.
     *
     *
     * Тестирование offsetSet() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что offsetSet() корректно обрабатывает специальные
     * символы в ключах, включая пробелы, UTF-8 и специальные символы.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray();

        $array['key with spaces'] = 'value1';
        $array['key-with-dashes'] = 'value2';
        $array['key.with.dots'] = 'value3';
        $array['café'] = 'coffee';
        $array['привет'] = 'hello';
        $array['🎉'] = 'party';

        $this->assertSame('value1', $array['key with spaces']);
        $this->assertSame('value2', $array['key-with-dashes']);
        $this->assertSame('value3', $array['key.with.dots']);
        $this->assertSame('coffee', $array['café']);
        $this->assertSame('hello', $array['привет']);
        $this->assertSame('party', $array['🎉']);

        // Direct method calls
        $array->offsetSet('test_key', 'test_value');
        $this->assertSame('test_value', $array['test_key']);
    }

    /**
     * Tests offsetSet() with resources and callables.
     *
     * This test verifies that resources and callable functions are stored
     * as-is without modification.
     *
     *
     * Тестирование offsetSet() с ресурсами и callable.
     *
     * Этот тест проверяет, что ресурсы и callable-функции сохраняются
     * как есть без изменений.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithResourcesAndCallables(): void
    {
        $array = new NewTypeArray();

        // Resource values
        $resource = fopen('php://memory', 'r+');
        fwrite($resource, 'test data');
        rewind($resource);

        $array['resource'] = $resource;
        $this->assertSame($resource, $array['resource']);
        $this->assertIsResource($array['resource']);
        fclose($resource);

        // Callable functions
        $closure = fn(int $a, int $b): int => $a + $b;
        $array['closure'] = $closure;
        $this->assertSame($closure, $array['closure']);
        $this->assertIsCallable($array['closure']);
        $this->assertSame(5, ($array['closure'])(2, 3));

        // Named function as string
        $array['function'] = 'strlen';
        $this->assertSame('strlen', $array['function']);
        $this->assertIsCallable($array['function']);
    }

    /**
     * Tests offsetSet() maintains referential integrity.
     *
     * This test verifies that when the same object is set to multiple
     * keys, references are maintained rather than creating copies.
     *
     *
     * Тестирование offsetSet() сохраняет ссылочную целостность.
     *
     * Этот тест проверяет, что когда один и тот же объект устанавливается
     * в несколько ключей, сохраняются ссылки, а не создаются копии.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetMaintainsReferences(): void
    {
        $array = new NewTypeArray();

        // Same object to multiple keys
        $sharedObject = new stdClass();
        $sharedObject->id = 'shared';

        $array['obj1'] = $sharedObject;
        $array['obj2'] = $sharedObject;

        // Both should reference the same object
        $this->assertSame($sharedObject, $array['obj1']);
        $this->assertSame($sharedObject, $array['obj2']);
        $this->assertSame($array['obj1'], $array['obj2']);

        // Modification through one affects both
        $array['obj1']->modified = true;
        $this->assertTrue($array['obj2']->modified);
        $this->assertTrue($sharedObject->modified);
    }

    /**
     * Tests offsetSet() with edge cases.
     *
     * This test covers edge cases including zero values, large numbers,
     * and special float values to ensure consistent behavior.
     *
     *
     * Тестирование offsetSet() с граничными случаями.
     *
     * Этот тест охватывает граничные случаи, включая нулевые значения,
     * большие числа и специальные значения float для обеспечения согласованного поведения.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithEdgeCases(): void
    {
        $array = new NewTypeArray();

        // Zero values
        $array['zero_int'] = 0;
        $array['zero_float'] = 0.0;
        $array['negative_zero'] = -0.0;

        $this->assertSame(0, $array['zero_int']);
        $this->assertSame(0.0, $array['zero_float']);

        // Large numbers
        $array['max_int'] = PHP_INT_MAX;
        $array['min_int'] = -PHP_INT_MAX - 1;
        $array['large_float'] = 1.8e308;

        $this->assertSame(PHP_INT_MAX, $array['max_int']);
        $this->assertSame(-PHP_INT_MAX - 1, $array['min_int']);

        // Special float values
        $array['inf'] = INF;
        $array['nan'] = NAN;

        $this->assertInfinite($array['inf']);
        $this->assertNan($array['nan']);

        // Float precision
        $array['precision'] = 0.1 + 0.2;
        $this->assertEqualsWithDelta(0.3, $array['precision'], 0.0000001);
    }

    /**
     * Tests offsetSet() with large datasets.
     *
     * This test verifies that offsetSet() works efficiently even with
     * large numbers of elements.
     *
     *
     * Тестирование offsetSet() с большими наборами данных.
     *
     * Этот тест проверяет, что offsetSet() работает эффективно даже с
     * большим количеством элементов.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithLargeDataset(): void
    {
        $array = new NewTypeArray();

        // Set many elements
        for ($i = 0; $i < 1000; $i++) {
            $array["key_$i"] = "value_$i";
        }

        // Verify random elements
        $this->assertSame('value_42', $array['key_42']);
        $this->assertSame('value_999', $array['key_999']);
        $this->assertSame('value_0', $array['key_0']);

        $this->assertCount(1000, $array);

        // Set with numeric indices
        $list = new NewTypeArray();
        for ($i = 0; $i < 1000; $i++) {
            $list[$i] = $i * 2;
        }

        $this->assertSame(84, $list[42]);
        $this->assertSame(1998, $list[999]);
    }

    /**
     * Tests offsetSet() chaining with nested access.
     *
     * This test verifies that you can chain offsetSet operations
     * to set deeply nested values.
     *
     *
     * Тестирование offsetSet() цепочки с вложенным доступом.
     *
     * Этот тест проверяет, что можно создавать цепочки операций offsetSet
     * для установки глубоко вложенных значений.
     *
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetWithNestedAccess(): void
    {
        $array = new NewTypeArray();

        // Create nested structure
        $array['user'] = [
            'name' => 'John',
            'profile' => [
                'age' => 30
            ]
        ];

        // Modify nested values
        $array['user']['profile']['city'] = 'Moscow';
        $array['user']['email'] = 'john@example.com';

        $this->assertSame('Moscow', $array['user']['profile']['city']);
        $this->assertSame('john@example.com', $array['user']['email']);
        $this->assertSame(30, $array['user']['profile']['age']);
    }
}
