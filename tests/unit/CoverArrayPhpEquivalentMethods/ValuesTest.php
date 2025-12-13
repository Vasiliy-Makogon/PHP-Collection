<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ValuesTest extends TestCase
{
    /**
     * Tests the values() method with associative array.
     *
     * This test verifies that the values() method correctly returns
     * all the values from the associative array, indexed numerically
     * starting from 0, mirroring PHP's array_values() function behavior.
     *
     *
     * Тестирование метода values() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод values() корректно возвращает
     * все значения из ассоциативного массива, индексированные численно
     * начиная с 0, отражая поведение функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with numeric keys out of order.
     *
     * This test verifies that the values() method correctly returns
     * all values re-indexed numerically starting from 0, regardless
     * of the original numeric keys order, mirroring PHP's array_values()
     * function behavior.
     *
     *
     * Тестирование метода values() с числовыми ключами не по порядку.
     *
     * Этот тест проверяет, что метод values() корректно возвращает
     * все значения переиндексированные численно начиная с 0, независимо
     * от порядка исходных числовых ключей, отражая поведение функции
     * array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithNumericKeysOutOfOrder(): void
    {
        // Test with numeric keys out of order
        // Тест с числовыми ключами не по порядку
        $data = [2 => 'two', 0 => 'zero', 1 => 'one', 5 => 'five'];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with empty array.
     *
     * This test verifies that the values() method correctly handles
     * empty arrays, returning an empty array, mirroring PHP's array_values()
     * function behavior.
     *
     *
     * Тестирование метода values() с пустым массивом.
     *
     * Этот тест проверяет, что метод values() корректно обрабатывает
     * пустые массивы, возвращая пустой массив, отражая поведение
     * функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method preserves value types.
     *
     * This test verifies that the values() method correctly preserves
     * all value types (string, integer, float, boolean, null, array, object),
     * mirroring PHP's array_values() function behavior.
     *
     *
     * Тестирование метода values() сохраняет типы значений.
     *
     * Этот тест проверяет, что метод values() корректно сохраняет
     * все типы значений (строка, целое число, число с плавающей точкой,
     * булево значение, null, массив, объект), отражая поведение
     * функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesPreservesValueTypes(): void
    {
        // Test with various value types
        // Тест с различными типами значений
        $object = new \stdClass();
        $object->property = 'test';

        $data = [
            'str' => 'string',
            'int' => 42,
            'float' => 3.14,
            'bool' => true,
            'null' => null,
            'array' => [1, 2, 3],
            'object' => $object
        ];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with mixed string and numeric keys.
     *
     * This test verifies that the values() method correctly handles
     * arrays with mixed string and numeric keys, returning all values
     * re-indexed numerically, mirroring PHP's array_values() function behavior.
     *
     *
     * Тестирование метода values() со смешанными строковыми и числовыми ключами.
     *
     * Этот тест проверяет, что метод values() корректно обрабатывает
     * массивы со смешанными строковыми и числовыми ключами, возвращая все значения
     * переиндексированные численно, отражая поведение функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithMixedStringAndNumericKeys(): void
    {
        // Test with mixed string and numeric keys
        // Тест со смешанными строковыми и числовыми ключами
        $data = [
            'first' => 'apple',
            0 => 'banana',
            'second' => 'cherry',
            2 => 'date',
            'third' => 'elderberry'
        ];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with sequential numeric keys.
     *
     * This test verifies that the values() method correctly handles
     * arrays with sequential numeric keys, returning the same array
     * (since it's already numerically indexed), mirroring PHP's array_values()
     * function behavior.
     *
     *
     * Тестирование метода values() с последовательными числовыми ключами.
     *
     * Этот тест проверяет, что метод values() корректно обрабатывает
     * массивы с последовательными числовыми ключами, возвращая тот же массив
     * (так как он уже численно индексирован), отражая поведение
     * функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithSequentialNumericKeys(): void
    {
        // Test with sequential numeric keys
        // Тест с последовательными числовыми ключами
        $data = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with nested arrays.
     *
     * This test verifies that the values() method correctly handles
     * arrays containing nested arrays, returning them as values without
     * modifying the nested structure, mirroring PHP's array_values() function behavior.
     *
     *
     * Тестирование метода values() с вложенными массивами.
     *
     * Этот тест проверяет, что метод values() корректно обрабатывает
     * массивы, содержащие вложенные массивы, возвращая их как значения без
     * изменения вложенной структуры, отражая поведение функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithNestedArrays(): void
    {
        // Test with nested arrays
        // Тест с вложенными массивами
        $data = [
            'a' => ['nested' => 'value1'],
            'b' => ['nested' => 'value2'],
            'c' => ['nested' => ['deep' => 'value3']]
        ];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->values()->getDataAsArray()
        );
    }

    /**
     * Tests the values() method with CoverArray as values.
     *
     * This test verifies that the values() method correctly handles
     * CoverArray objects as values in the array, returning them as values
     * without modification, mirroring PHP's array_values() function behavior.
     *
     *
     * Тестирование метода values() со значениями типа CoverArray.
     *
     * Этот тест проверяет, что метод values() корректно обрабатывает
     * объекты CoverArray как значения в массиве, возвращая их как значения
     * без изменений, отражая поведение функции array_values() PHP.
     *
     * @see CoverArray::values()
     * @see array_values()
     */
    public function testValuesWithCoverArrayAsValues(): void
    {
        // Test with CoverArray as values
        // Тест со значениями типа CoverArray
        $cover1 = new CoverArray(['x' => 1, 'y' => 2]);
        $cover2 = new CoverArray(['a' => 'test']);

        $data = [
            'first' => $cover1,
            'second' => 'string',
            'third' => $cover2
        ];

        $expected = array_values($data);

        $cover = new CoverArray($data);
        $result = $cover->values();

        $this->assertCount(3, $result);
        $this->assertSame($cover1, $result[0]);
        $this->assertSame('string', $result[1]);
        $this->assertSame($cover2, $result[2]);
    }

    /**
     * Tests the values() method returns CoverArray instance.
     *
     * This test verifies that the values() method returns a new
     * CoverArray instance rather than a plain array.
     *
     *
     * Тестирование, что values() возвращает экземпляр CoverArray.
     *
     * Этот тест проверяет, что метод values() возвращает новый
     * экземпляр CoverArray, а не обычный массив.
     *
     * @see CoverArray::values()
     */
    public function testValuesReturnsCoverArrayInstance(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover = new CoverArray($data);

        $result = $cover->values();

        $this->assertInstanceOf(CoverArray::class, $result);
    }
}