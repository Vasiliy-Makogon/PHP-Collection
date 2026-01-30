<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class SumTest extends TestCase
{
    /**
     * Tests the sum() method with integer values.
     *
     * This test verifies that the sum() method correctly calculates
     * the sum of integer values in the array, mirroring PHP's array_sum()
     * function behavior.
     *
     *
     * Тестирование метода sum() с целочисленными значениями.
     *
     * Этот тест проверяет, что метод sum() корректно вычисляет
     * сумму целочисленных значений в массиве, отражая поведение
     * функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithIntegers(): void
    {
        $data = [1, 2, 3, 4, 5];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with float values.
     *
     * This test verifies that the sum() method correctly calculates
     * the sum of float values in the array, mirroring PHP's array_sum()
     * function behavior.
     *
     *
     * Тестирование метода sum() с дробными значениями.
     *
     * Этот тест проверяет, что метод sum() корректно вычисляет
     * сумму дробных значений в массиве, отражая поведение
     * функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithFloats(): void
    {
        $data = [1.5, 2.5, 3.5, 4.5];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with mixed integer and float values.
     *
     * This test verifies that the sum() method correctly calculates
     * the sum of mixed integer and float values, mirroring PHP's
     * array_sum() function behavior.
     *
     *
     * Тестирование метода sum() со смешанными целыми и дробными значениями.
     *
     * Этот тест проверяет, что метод sum() корректно вычисляет
     * сумму смешанных целых и дробных значений, отражая поведение
     * функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithMixedNumbers(): void
    {
        $data = [1, 2.5, 3, 4.5, 5];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with empty array.
     *
     * This test verifies that the sum() method returns 0 for an empty
     * array, mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с пустым массивом.
     *
     * Этот тест проверяет, что метод sum() возвращает 0 для пустого
     * массива, отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithEmptyArray(): void
    {
        $data = [];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with negative numbers.
     *
     * This test verifies that the sum() method correctly handles
     * negative numbers, mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с отрицательными числами.
     *
     * Этот тест проверяет, что метод sum() корректно обрабатывает
     * отрицательные числа, отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithNegativeNumbers(): void
    {
        $data = [-1, -2, -3, -4, -5];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with mixed positive and negative numbers.
     *
     * This test verifies that the sum() method correctly calculates
     * the sum when the array contains both positive and negative numbers,
     * mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() со смешанными положительными и отрицательными числами.
     *
     * Этот тест проверяет, что метод sum() корректно вычисляет
     * сумму, когда массив содержит как положительные, так и отрицательные числа,
     * отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithMixedPositiveAndNegative(): void
    {
        $data = [10, -5, 3, -2, 7];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with zeros.
     *
     * This test verifies that the sum() method correctly handles
     * arrays containing zeros, mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с нулями.
     *
     * Этот тест проверяет, что метод sum() корректно обрабатывает
     * массивы, содержащие нули, отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithZeros(): void
    {
        $data = [0, 0, 0, 5, 0];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with string values.
     *
     * This test verifies that the sum() method correctly handles string
     * values by converting them to numbers, mirroring PHP's array_sum()
     * function behavior.
     *
     *
     * Тестирование метода sum() со строковыми значениями.
     *
     * Этот тест проверяет, что метод sum() корректно обрабатывает
     * строковые значения, преобразуя их в числа, отражая поведение
     * функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithStringNumbers(): void
    {
        $data = ['1', '2', '3', '4'];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with associative array.
     *
     * This test verifies that the sum() method correctly calculates
     * the sum of values in an associative array, ignoring keys,
     * mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод sum() корректно вычисляет
     * сумму значений в ассоциативном массиве, игнорируя ключи,
     * отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithAssociativeArray(): void
    {
        $data = ['a' => 10, 'b' => 20, 'c' => 30];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with null values.
     *
     * This test verifies that the sum() method correctly handles
     * null values by treating them as 0, mirroring PHP's
     * array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с null значениями.
     *
     * Этот тест проверяет, что метод sum() корректно обрабатывает
     * null значения, считая их как 0, отражая поведение
     * функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithNullValues(): void
    {
        $data = [1, 3, null, 5];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with large numbers.
     *
     * This test verifies that the sum() method correctly handles
     * large numbers, mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с большими числами.
     *
     * Этот тест проверяет, что метод sum() корректно обрабатывает
     * большие числа, отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithLargeNumbers(): void
    {
        $data = [1000000, 2000000, 3000000];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }

    /**
     * Tests the sum() method with only one element.
     *
     * This test verifies that the sum() method correctly returns
     * the single element value when array has only one element,
     * mirroring PHP's array_sum() function behavior.
     *
     *
     * Тестирование метода sum() с одним элементом.
     *
     * Этот тест проверяет, что метод sum() корректно возвращает
     * значение единственного элемента, когда массив содержит только один элемент,
     * отражая поведение функции array_sum() PHP.
     *
     * @see CoverArray::sum()
     * @see array_sum()
     */
    public function testSumWithSingleElement(): void
    {
        $data = [42];
        $expected = array_sum($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->sum());
    }
}
