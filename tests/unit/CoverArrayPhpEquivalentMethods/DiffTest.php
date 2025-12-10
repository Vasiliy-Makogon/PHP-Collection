<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffTest extends TestCase
{
    /**
     * Tests the diff() method with simple arrays.
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays for simple indexed arrays,
     * comparing values across multiple arrays, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с простыми массивами.
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов для простых индексных массивов,
     * сравнивая значения через несколько массивов, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithSimpleArrays(): void
    {
        // Test with simple arrays
        // Тест с простыми массивами
        $data = [1, 2, 3, 4, 5];
        $diff1 = [2, 4];
        $diff2 = [3];

        $expected = array_diff($data, $diff1, $diff2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with associative arrays.
     *
     * This test verifies that the diff() method correctly computes
     * the difference of associative arrays, comparing values (not keys)
     * across arrays, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение ассоциативных массивов, сравнивая значения (не ключи)
     * через массивы, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithAssociativeArrays(): void
    {
        // Test with associative arrays (compares values, not keys)
        // Тест с ассоциативными массивами (сравнивает значения, не ключи)
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $diff = ['banana', 'date'];

        $expected = array_diff($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with mixed types.
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays with mixed types (integers and strings),
     * comparing values with strict type comparison, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() со смешанными типами.
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов со смешанными типами (целые числа и строки),
     * сравнивая значения со строгим сравнением типов, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithMixedTypes(): void
    {
        // Test with mixed types
        // Тест со смешанными типами
        $data = [1, '1', 2, '2', 3];
        $diff = [1, '2'];

        $expected = array_diff($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with empty diff array.
     *
     * This test verifies that the diff() method correctly handles
     * empty diff arrays, returning the entire original array,
     * mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с пустым массивом для сравнения.
     *
     * Этот тест проверяет, что метод diff() корректно обрабатывает
     * пустые массивы для сравнения, возвращая весь исходный массив,
     * отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithEmptyDiffArray(): void
    {
        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data = ['a', 'b', 'c'];
        $diff = [];

        $expected = array_diff($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with multiple diff arrays.
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays with multiple comparison arrays,
     * comparing values across all arrays, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с несколькими массивами для сравнения.
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов с несколькими массивами для сравнения,
     * сравнивая значения через все массивы, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithMultipleDiffArrays(): void
    {
        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data = ['red', 'green', 'blue', 'yellow', 'purple'];
        $diff1 = ['green', 'yellow'];
        $diff2 = ['red'];
        $diff3 = ['blue'];

        $expected = array_diff($data, $diff1, $diff2, $diff3);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff1, $diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(
                new CoverArray($diff1),
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with three diff arrays of different types.
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays with three comparison arrays of mixed argument types,
     * comparing values across all arrays, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с тремя массивами для сравнения разных типов.
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов с тремя массивами для сравнения смешанных типов аргументов,
     * сравнивая значения через все массивы, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithThreeDiffArraysMixedTypes(): void
    {
        // Test with three diff arrays of different types
        // Тест с тремя массивами для сравнения разных типов
        $data = [1, 2, 3, 4, 5, 6, 7];
        $diff1 = [2, 4];
        $diff2 = new CoverArray([3, 5]);
        $diff3 = [6];

        $expected = array_diff($data, [2, 4], [3, 5], [6]);

        $cover = new CoverArray($data);

        $result = $cover->diff($diff1, $diff2, $diff3);
        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the diff() method with all values present in diff arrays.
     *
     * This test verifies that the diff() method correctly returns
     * an empty array when all values are present in the diff arrays,
     * mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff(), когда все значения присутствуют в массивах сравнения.
     *
     * Этот тест проверяет, что метод diff() корректно возвращает
     * пустой массив, когда все значения присутствуют в массивах сравнения,
     * отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithAllValuesInDiffArrays(): void
    {
        // Test with all values present in diff arrays
        // Тест, когда все значения присутствуют в массивах сравнения
        $data = ['a', 'b', 'c'];
        $diff1 = ['a', 'b'];
        $diff2 = ['c'];

        $expected = array_diff($data, $diff1, $diff2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the diff() method with duplicate values.
     *
     * This test verifies that the diff() method correctly handles
     * duplicate values in the original array, removing all occurrences
     * of values found in diff arrays, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод diff() корректно обрабатывает
     * дублирующиеся значения в исходном массиве, удаляя все вхождения
     * значений, найденных в массивах сравнения, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffWithDuplicateValues(): void
    {
        // Test with duplicate values
        // Тест с дублирующимися значениями
        $data = ['a', 'b', 'a', 'c', 'b', 'd'];
        $diff = ['a', 'b'];

        $expected = array_diff($data, $diff);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->diff($diff)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->diff(new CoverArray($diff))->getDataAsArray()
        );
    }
}