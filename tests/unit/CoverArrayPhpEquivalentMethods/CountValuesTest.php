<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CountValuesTest extends TestCase
{
    /**
     * Tests the countValues() method with simple array of strings.
     *
     * This test verifies that the countValues() method correctly counts
     * the occurrences of each string value in the CoverArray,
     * mirroring the behavior of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() с простым массивом строк.
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * количество вхождений каждого строкового значения в CoverArray,
     * отражая поведение функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithSimpleArrayOfStrings(): void
    {
        // Test with simple array of strings
        // Тест с простым массивом строк
        $data = ['apple', 'banana', 'apple', 'orange', 'banana', 'apple'];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the countValues() method with array of numbers.
     *
     * This test verifies that the countValues() method correctly counts
     * the occurrences of each numeric value in the CoverArray,
     * mirroring the behavior of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() с массивом чисел.
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * количество вхождений каждого числового значения в CoverArray,
     * отражая поведение функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithArrayOfNumbers(): void
    {
        // Test with numbers
        // Тест с числами
        $data = [1, 2, 1, 3, 2, 1, 1];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the countValues() method with empty array.
     *
     * This test verifies that the countValues() method correctly handles
     * empty arrays, returning an empty CoverArray, mirroring the behavior
     * of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() с пустым массивом.
     *
     * Этот тест проверяет, что метод countValues() корректно обрабатывает
     * пустые массивы, возвращая пустой CoverArray, отражая поведение
     * функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the countValues() method with mixed string and number values.
     *
     * This test verifies that the countValues() method correctly handles
     * arrays with mixed string and numeric values, counting occurrences
     * of each value independently of type, mirroring the behavior
     * of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() со смешанными строками и числами.
     *
     * Этот тест проверяет, что метод countValues() корректно обрабатывает
     * массивы со смешанными строковыми и числовыми значениями, подсчитывая
     * вхождения каждого значения независимо от типа, отражая поведение
     * функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithMixedStringAndNumberValues(): void
    {
        // Test with mixed string and number values
        // Тест со смешанными строками и числами
        $data = ['apple', 1, 'banana', 1, 'apple', 2, 'apple'];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the countValues() method with associative array.
     *
     * This test verifies that the countValues() method correctly counts
     * values from an associative array, ignoring the keys and focusing
     * only on the values, mirroring the behavior of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * значения из ассоциативного массива, игнорируя ключи и фокусируясь
     * только на значениях, отражая поведение функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'apple', 'd' => 'cherry', 'e' => 'banana'];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the countValues() method with integer string values.
     *
     * This test verifies that the countValues() method correctly handles
     * string representations of integers, treating them as strings
     * (not as integers), mirroring the behavior of PHP's array_count_values() function.
     *
     *
     * Тестирование метода countValues() со строковыми представлениями целых чисел.
     *
     * Этот тест проверяет, что метод countValues() корректно обрабатывает
     * строковые представления целых чисел, рассматривая их как строки
     * (а не как целые числа), отражая поведение функции array_count_values() PHP.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesWithIntegerStringValues(): void
    {
        // Test with integer string values
        // Тест со строковыми представлениями целых чисел
        $data = ['1', '2', '1', '3', '2', '1'];

        $expected = array_count_values($data);

        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());
    }
}