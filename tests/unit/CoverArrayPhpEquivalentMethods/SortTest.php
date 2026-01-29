<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class SortTest extends TestCase
{
    /**
     * Tests the sort() method with default sorting flags.
     *
     * This test verifies that the sort() method correctly sorts an array
     * in ascending order,
     * mirroring PHP's sort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода sort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод sort() корректно сортирует массив
     * в порядке возрастания,
     * отражая поведение функции sort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithDefaultFlags(): void
    {
        $data = [3, 1, 2];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the sort() method correctly sorts an array
     * numerically in ascending order,
     * mirroring PHP's sort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода sort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод sort() корректно сортирует массив
     * численно в порядке возрастания,
     * отражая поведение функции sort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithSortNumeric(): void
    {
        $data = ['10', '2', '30'];
        $dataCopy = $data;

        sort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with SORT_STRING flag.
     *
     * This test verifies that the sort() method correctly sorts an array
     * as strings in ascending order,
     * mirroring PHP's sort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода sort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод sort() корректно сортирует массив
     * как строки в порядке возрастания,
     * отражая поведение функции sort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithSortString(): void
    {
        $data = ['cherry', 'apple', 'banana'];
        $dataCopy = $data;

        sort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with SORT_NATURAL flag.
     *
     * This test verifies that the sort() method correctly performs
     * natural order sorting in ascending order,
     * mirroring PHP's sort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода sort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод sort() корректно выполняет
     * естественную сортировку в порядке возрастания,
     * отражая поведение функции sort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithSortNatural(): void
    {
        $data = ['img12.png', 'img2.png', 'img1.png'];
        $dataCopy = $data;

        sort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the sort() method correctly performs
     * case-insensitive natural order sorting in ascending order,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод sort() корректно выполняет
     * регистронезависимую естественную сортировку в порядке возрастания,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['File10.txt', 'file2.txt', 'FILE1.txt'];
        $dataCopy = $data;

        sort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with empty array.
     *
     * This test verifies that the sort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() с пустым массивом.
     *
     * Этот тест проверяет, что метод sort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with single element.
     *
     * This test verifies that the sort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() с одним элементом.
     *
     * Этот тест проверяет, что метод sort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method resetting keys.
     *
     * This test verifies that the sort() method resets numeric keys
     * after sorting, starting from 0,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() со сбросом ключей.
     *
     * Этот тест проверяет, что метод sort() сбрасывает числовые ключи
     * после сортировки, начиная с 0,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortResettingKeys(): void
    {
        $data = ['a' => 100, 'b' => 50, 'c' => 75];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check sorted array with reset keys
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey(0, $cover->getDataAsArray());
        $this->assertArrayHasKey(1, $cover->getDataAsArray());
        $this->assertArrayHasKey(2, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with duplicate values.
     *
     * This test verifies that the sort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод sort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithDuplicateValues(): void
    {
        $data = [2, 3, 2, 1];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with mixed numeric and string values.
     *
     * This test verifies that the sort() method correctly sorts
     * arrays containing mixed types,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() со смешанными числовыми и строковыми значениями.
     *
     * Этот тест проверяет, что метод sort() корректно сортирует
     * массивы, содержащие смешанные типы,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithMixedTypes(): void
    {
        $data = [10, 'apple', 5, 'banana'];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the sort() method with negative numbers.
     *
     * This test verifies that the sort() method correctly sorts
     * arrays containing negative numbers in ascending order,
     * mirroring PHP's sort() function behavior.
     *
     *
     * Тестирование метода sort() с отрицательными числами.
     *
     * Этот тест проверяет, что метод sort() корректно сортирует
     * массивы, содержащие отрицательные числа, в порядке возрастания,
     * отражая поведение функции sort() PHP.
     *
     * @see CoverArray::sort()
     * @see sort()
     */
    public function testSortWithNegativeNumbers(): void
    {
        $data = [-5, 10, -15, 0];
        $dataCopy = $data;

        sort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->sort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
