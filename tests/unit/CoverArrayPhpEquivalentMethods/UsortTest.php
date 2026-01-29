<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UsortTest extends TestCase
{
    /**
     * Tests the usort() method with ascending comparison.
     *
     * This test verifies that the usort() method correctly sorts an array
     * using a user-defined comparison function in ascending order,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с сортировкой по возрастанию.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует массив
     * с использованием пользовательской функции сравнения по возрастанию,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithAscendingComparison(): void
    {
        $data = [3, 1, 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with descending comparison.
     *
     * This test verifies that the usort() method correctly sorts an array
     * using a user-defined comparison function in descending order,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с сортировкой по убыванию.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует массив
     * с использованием пользовательской функции сравнения по убыванию,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithDescendingComparison(): void
    {
        $data = [1, 3, 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $b <=> $a;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method resetting keys.
     *
     * This test verifies that the usort() method resets numeric keys
     * after sorting, starting from 0,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() со сбросом ключей.
     *
     * Этот тест проверяет, что метод usort() сбрасывает числовые ключи
     * после сортировки, начиная с 0,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortResettingKeys(): void
    {
        $data = ['first' => 100, 'second' => 50, 'third' => 75];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array with reset keys
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey(0, $cover->getDataAsArray());
        $this->assertArrayHasKey(1, $cover->getDataAsArray());
        $this->assertArrayHasKey(2, $cover->getDataAsArray());
        $this->assertArrayNotHasKey('first', $cover->getDataAsArray());
        $this->assertArrayNotHasKey('second', $cover->getDataAsArray());
        $this->assertArrayNotHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with string comparison.
     *
     * This test verifies that the usort() method correctly sorts
     * an array of strings using a custom comparison function,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с сравнением строк.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует
     * массив строк с использованием пользовательской функции сравнения,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithStringComparison(): void
    {
        $data = ['cherry', 'apple', 'banana'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcmp($a, $b);

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with case-insensitive string comparison.
     *
     * This test verifies that the usort() method correctly sorts
     * an array using case-insensitive string comparison,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с регистронезависимым сравнением строк.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует
     * массив с использованием регистронезависимого сравнения строк,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithCaseInsensitiveComparison(): void
    {
        $data = ['Cherry', 'apple', 'Banana'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcasecmp($a, $b);

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with empty array.
     *
     * This test verifies that the usort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с пустым массивом.
     *
     * Этот тест проверяет, что метод usort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with single element.
     *
     * This test verifies that the usort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с одним элементом.
     *
     * Этот тест проверяет, что метод usort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with custom comparison logic.
     *
     * This test verifies that the usort() method correctly applies
     * custom comparison logic (e.g., sorting by string length),
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с пользовательской логикой сравнения.
     *
     * Этот тест проверяет, что метод usort() корректно применяет
     * пользовательскую логику сравнения (например, сортировка по длине строки),
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithCustomComparisonLogic(): void
    {
        $data = ['short', 'very long string', 'medium'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strlen($a) <=> strlen($b);

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with duplicate values.
     *
     * This test verifies that the usort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод usort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithDuplicateValues(): void
    {
        $data = [2, 3, 2, 1];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with numeric values.
     *
     * This test verifies that the usort() method correctly sorts
     * arrays with numeric values including negative numbers,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() с числовыми значениями.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует
     * массивы с числовыми значениями, включая отрицательные числа,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithNumericValues(): void
    {
        $data = [10, -5, 0, 15, -10];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the usort() method with mixed types.
     *
     * This test verifies that the usort() method correctly sorts
     * arrays containing mixed value types,
     * mirroring PHP's usort() function behavior.
     *
     *
     * Тестирование метода usort() со смешанными типами.
     *
     * Этот тест проверяет, что метод usort() корректно сортирует
     * массивы, содержащие значения смешанных типов,
     * отражая поведение функции usort() PHP.
     *
     * @see CoverArray::usort()
     * @see usort()
     */
    public function testUsortWithMixedTypes(): void
    {
        $data = [10, 'apple', 5, 'banana'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcmp((string)$a, (string)$b);

        usort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->usort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
