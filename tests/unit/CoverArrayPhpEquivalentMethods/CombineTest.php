<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CombineTest extends TestCase
{
    /**
     * Tests the combine() method with both arguments as arrays.
     *
     * This test verifies that the combine() static method correctly creates
     * a new CoverArray by using one array for keys and another for values
     * when both arguments are plain PHP arrays, mirroring the behavior
     * of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с обоими аргументами в виде массивов.
     *
     * Этот тест проверяет, что статический метод combine() корректно создает
     * новый CoverArray, используя один массив для ключей, а другой для значений,
     * когда оба аргумента являются обычными массивами PHP, отражая поведение
     * функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithBothArgumentsAsArrays(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine($keys, $values);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with both arguments as CoverArray objects.
     *
     * This test verifies that the combine() static method correctly creates
     * a new CoverArray by using one CoverArray for keys and another for values
     * when both arguments are CoverArray objects, mirroring the behavior
     * of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с обоими аргументами в виде объектов CoverArray.
     *
     * Этот тест проверяет, что статический метод combine() корректно создает
     * новый CoverArray, используя один CoverArray для ключей, а другой для значений,
     * когда оба аргумента являются объектами CoverArray, отражая поведение
     * функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithBothArgumentsAsCoverArray(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine(
            new CoverArray($keys),
            new CoverArray($values)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with first argument as array and second as CoverArray.
     *
     * This test verifies that the combine() static method correctly handles
     * mixed argument types, using a plain PHP array for keys and a CoverArray
     * for values, mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с первым аргументом как массив и вторым как CoverArray.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * смешанные типы аргументов, используя обычный массив PHP для ключей и CoverArray
     * для значений, отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithFirstArraySecondCoverArray(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine(
            $keys,
            new CoverArray($values)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with first argument as CoverArray and second as array.
     *
     * This test verifies that the combine() static method correctly handles
     * mixed argument types, using a CoverArray for keys and a plain PHP array
     * for values, mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с первым аргументом как CoverArray и вторым как массив.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * смешанные типы аргументов, используя CoverArray для ключей и обычный массив PHP
     * для значений, отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithFirstCoverArraySecondArray(): void
    {
        $keys = ['name', 'age', 'city'];
        $values = ['John', 30, 'New York'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine(
            new CoverArray($keys),
            $values
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with numeric keys.
     *
     * This test verifies that the combine() static method correctly handles
     * numeric keys, creating an associative array with numeric string keys,
     * mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с числовыми ключами.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * числовые ключи, создавая ассоциативный массив с числовыми строковыми ключами,
     * отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithNumericKeys(): void
    {
        $keys = [1, 2, 3];
        $values = ['one', 'two', 'three'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine($keys, $values);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with mixed key types.
     *
     * This test verifies that the combine() static method correctly handles
     * mixed key types (strings and integers), creating an associative array
     * with mixed keys, mirroring the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() со смешанными типами ключей.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * смешанные типы ключей (строки и целые числа), создавая ассоциативный массив
     * со смешанными ключами, отражая поведение функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithMixedKeyTypes(): void
    {
        $keys = ['name', 0, 'city'];
        $values = ['John', 'zero', 'New York'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine($keys, $values);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with empty arrays.
     *
     * This test verifies that the combine() static method correctly handles
     * empty arrays, returning an empty CoverArray, mirroring the behavior
     * of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с пустыми массивами.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * пустые массивы, возвращая пустой CoverArray, отражая поведение
     * функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithEmptyArrays(): void
    {
        $keys = [];
        $values = [];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine($keys, $values);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the combine() method with arrays of different lengths.
     *
     * This test verifies that the combine() static method throws a ValueError
     * when the keys and values arrays have different lengths, mirroring
     * the behavior of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с массивами разной длины.
     *
     * Этот тест проверяет, что статический метод combine() выбрасывает ValueError,
     * когда массивы ключей и значений имеют разную длину, отражая поведение
     * функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithArraysOfDifferentLengths(): void
    {
        $keys = ['name', 'age'];
        $values = ['John', 30, 'extra'];

        $this->expectException(\ValueError::class);
        CoverArray::combine($keys, $values);
    }

    /**
     * Tests the combine() method with boolean and null values.
     *
     * This test verifies that the combine() static method correctly handles
     * boolean and null values in the values array, mirroring the behavior
     * of PHP's array_combine() function.
     *
     *
     * Тестирование метода combine() с boolean и null значениями.
     *
     * Этот тест проверяет, что статический метод combine() корректно обрабатывает
     * boolean и null значения в массиве значений, отражая поведение
     * функции array_combine() PHP.
     *
     * @see CoverArray::combine()
     * @see array_combine()
     */
    public function testCombineWithBooleanAndNullValues(): void
    {
        $keys = ['a', 'b', 'c', 'd'];
        $values = [true, false, null, 'string'];

        $expected = array_combine($keys, $values);

        $result = CoverArray::combine($keys, $values);

        $this->assertSame($expected, $result->getDataAsArray());
    }
}