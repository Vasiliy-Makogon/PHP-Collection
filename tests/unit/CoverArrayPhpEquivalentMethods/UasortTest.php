<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UasortTest extends TestCase
{
    /**
     * Tests the uasort() method with ascending comparison.
     *
     * This test verifies that the uasort() method correctly sorts an array
     * using a user-defined comparison function in ascending order
     * while maintaining index association,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с сортировкой по возрастанию.
     *
     * Этот тест проверяет, что метод uasort() корректно сортирует массив
     * с использованием пользовательской функции сравнения по возрастанию,
     * сохраняя ассоциацию индексов,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithAscendingComparison(): void
    {
        $data = ['a' => 3, 'b' => 1, 'c' => 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with descending comparison.
     *
     * This test verifies that the uasort() method correctly sorts an array
     * using a user-defined comparison function in descending order
     * while maintaining index association,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с сортировкой по убыванию.
     *
     * Этот тест проверяет, что метод uasort() корректно сортирует массив
     * с использованием пользовательской функции сравнения по убыванию,
     * сохраняя ассоциацию индексов,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithDescendingComparison(): void
    {
        $data = ['a' => 1, 'b' => 3, 'c' => 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $b <=> $a;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method preserving keys.
     *
     * This test verifies that the uasort() method maintains
     * the association between keys and values after sorting,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с сохранением ключей.
     *
     * Этот тест проверяет, что метод uasort() сохраняет
     * ассоциацию между ключами и значениями после сортировки,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortPreservingKeys(): void
    {
        $data = ['first' => 100, 'second' => 50, 'third' => 75];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array and key preservation
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('first', $cover->getDataAsArray());
        $this->assertArrayHasKey('second', $cover->getDataAsArray());
        $this->assertArrayHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with string comparison.
     *
     * This test verifies that the uasort() method correctly sorts
     * an array of strings using a custom comparison function,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с сравнением строк.
     *
     * Этот тест проверяет, что метод uasort() корректно сортирует
     * массив строк с использованием пользовательской функции сравнения,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithStringComparison(): void
    {
        $data = ['a' => 'cherry', 'b' => 'apple', 'c' => 'banana'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcmp($a, $b);

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with case-insensitive string comparison.
     *
     * This test verifies that the uasort() method correctly sorts
     * an array using case-insensitive string comparison,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с регистронезависимым сравнением строк.
     *
     * Этот тест проверяет, что метод uasort() корректно сортирует
     * массив с использованием регистронезависимого сравнения строк,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithCaseInsensitiveComparison(): void
    {
        $data = ['a' => 'Cherry', 'b' => 'apple', 'c' => 'Banana'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcasecmp($a, $b);

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with empty array.
     *
     * This test verifies that the uasort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с пустым массивом.
     *
     * Этот тест проверяет, что метод uasort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with single element.
     *
     * This test verifies that the uasort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с одним элементом.
     *
     * Этот тест проверяет, что метод uasort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithSingleElement(): void
    {
        $data = ['a' => 42];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with custom comparison logic.
     *
     * This test verifies that the uasort() method correctly applies
     * custom comparison logic (e.g., sorting by string length),
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с пользовательской логикой сравнения.
     *
     * Этот тест проверяет, что метод uasort() корректно применяет
     * пользовательскую логику сравнения (например, сортировка по длине строки),
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithCustomComparisonLogic(): void
    {
        $data = ['a' => 'short', 'b' => 'very long string', 'c' => 'medium'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strlen($a) <=> strlen($b);

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with duplicate values.
     *
     * This test verifies that the uasort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод uasort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithDuplicateValues(): void
    {
        $data = ['a' => 2, 'b' => 3, 'c' => 2, 'd' => 1];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uasort() method with numeric keys.
     *
     * This test verifies that the uasort() method correctly sorts
     * arrays with numeric keys while preserving those keys,
     * mirroring PHP's uasort() function behavior.
     *
     *
     * Тестирование метода uasort() с числовыми ключами.
     *
     * Этот тест проверяет, что метод uasort() корректно сортирует
     * массивы с числовыми ключами, сохраняя эти ключи,
     * отражая поведение функции uasort() PHP.
     *
     * @see CoverArray::uasort()
     * @see uasort()
     */
    public function testUasortWithNumericKeys(): void
    {
        $data = [10 => 'c', 2 => 'a', 5 => 'b'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uasort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uasort($comparison);

        // Check sorted array with preserved numeric keys
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey(10, $cover->getDataAsArray());
        $this->assertArrayHasKey(2, $cover->getDataAsArray());
        $this->assertArrayHasKey(5, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
