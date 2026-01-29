<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UksortTest extends TestCase
{
    /**
     * Tests the uksort() method with ascending comparison.
     *
     * This test verifies that the uksort() method correctly sorts an array
     * by keys using a user-defined comparison function in ascending order,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с сортировкой по возрастанию.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует массив
     * по ключам с использованием пользовательской функции сравнения по возрастанию,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithAscendingComparison(): void
    {
        $data = ['c' => 3, 'a' => 1, 'b' => 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with descending comparison.
     *
     * This test verifies that the uksort() method correctly sorts an array
     * by keys using a user-defined comparison function in descending order,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с сортировкой по убыванию.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует массив
     * по ключам с использованием пользовательской функции сравнения по убыванию,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithDescendingComparison(): void
    {
        $data = ['a' => 1, 'c' => 3, 'b' => 2];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $b <=> $a;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method sorting by keys.
     *
     * This test verifies that the uksort() method sorts
     * by keys while values remain associated with their keys,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с сортировкой по ключам.
     *
     * Этот тест проверяет, что метод uksort() сортирует
     * по ключам, в то время как значения остаются связанными с их ключами,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortSortingByKeys(): void
    {
        $data = ['third' => 100, 'first' => 50, 'second' => 75];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array and key-value associations
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame(50, $cover['first']);
        $this->assertSame(75, $cover['second']);
        $this->assertSame(100, $cover['third']);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with string key comparison.
     *
     * This test verifies that the uksort() method correctly sorts
     * an array by string keys using a custom comparison function,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с сравнением строковых ключей.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует
     * массив по строковым ключам с использованием пользовательской функции сравнения,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithStringKeyComparison(): void
    {
        $data = ['cherry' => 1, 'apple' => 2, 'banana' => 3];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcmp($a, $b);

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with case-insensitive key comparison.
     *
     * This test verifies that the uksort() method correctly sorts
     * an array using case-insensitive key comparison,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с регистронезависимым сравнением ключей.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует
     * массив с использованием регистронезависимого сравнения ключей,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithCaseInsensitiveComparison(): void
    {
        $data = ['Cherry' => 1, 'apple' => 2, 'Banana' => 3];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcasecmp($a, $b);

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with empty array.
     *
     * This test verifies that the uksort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с пустым массивом.
     *
     * Этот тест проверяет, что метод uksort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with single element.
     *
     * This test verifies that the uksort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с одним элементом.
     *
     * Этот тест проверяет, что метод uksort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithSingleElement(): void
    {
        $data = ['a' => 42];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with custom comparison logic.
     *
     * This test verifies that the uksort() method correctly applies
     * custom comparison logic (e.g., sorting by key length),
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с пользовательской логикой сравнения.
     *
     * Этот тест проверяет, что метод uksort() корректно применяет
     * пользовательскую логику сравнения (например, сортировка по длине ключа),
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithCustomComparisonLogic(): void
    {
        $data = ['short' => 1, 'very_long_key' => 2, 'medium' => 3];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strlen($a) <=> strlen($b);

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with numeric keys.
     *
     * This test verifies that the uksort() method correctly sorts
     * arrays with numeric keys using custom comparison,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() с числовыми ключами.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует
     * массивы с числовыми ключами с использованием пользовательского сравнения,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithNumericKeys(): void
    {
        $data = [10 => 'ten', 2 => 'two', 5 => 'five', 1 => 'one'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => $a <=> $b;

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the uksort() method with mixed key types.
     *
     * This test verifies that the uksort() method correctly sorts
     * arrays containing mixed string and numeric keys,
     * mirroring PHP's uksort() function behavior.
     *
     *
     * Тестирование метода uksort() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод uksort() корректно сортирует
     * массивы, содержащие смешанные строковые и числовые ключи,
     * отражая поведение функции uksort() PHP.
     *
     * @see CoverArray::uksort()
     * @see uksort()
     */
    public function testUksortWithMixedKeyTypes(): void
    {
        $data = [10 => 'number', 'apple' => 'fruit', 5 => 'five', 'banana' => 'yellow'];
        $dataCopy = $data;

        $comparison = fn($a, $b) => strcmp((string)$a, (string)$b);

        uksort($data, $comparison);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->uksort($comparison);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
