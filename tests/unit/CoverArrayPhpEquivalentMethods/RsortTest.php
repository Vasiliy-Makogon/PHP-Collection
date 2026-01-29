<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class RsortTest extends TestCase
{
    /**
     * Tests the rsort() method with default sorting flags.
     *
     * This test verifies that the rsort() method correctly sorts an array
     * in descending order,
     * mirroring PHP's rsort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода rsort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод rsort() корректно сортирует массив
     * в порядке убывания,
     * отражая поведение функции rsort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithDefaultFlags(): void
    {
        $data = [3, 1, 2];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the rsort() method correctly sorts an array
     * numerically in descending order,
     * mirroring PHP's rsort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода rsort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод rsort() корректно сортирует массив
     * численно в порядке убывания,
     * отражая поведение функции rsort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithSortNumeric(): void
    {
        $data = ['10', '2', '30'];
        $dataCopy = $data;

        rsort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with SORT_STRING flag.
     *
     * This test verifies that the rsort() method correctly sorts an array
     * as strings in descending order,
     * mirroring PHP's rsort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода rsort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод rsort() корректно сортирует массив
     * как строки в порядке убывания,
     * отражая поведение функции rsort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithSortString(): void
    {
        $data = ['cherry', 'apple', 'banana'];
        $dataCopy = $data;

        rsort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with SORT_NATURAL flag.
     *
     * This test verifies that the rsort() method correctly performs
     * natural order sorting in descending order,
     * mirroring PHP's rsort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода rsort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод rsort() корректно выполняет
     * естественную сортировку в порядке убывания,
     * отражая поведение функции rsort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithSortNatural(): void
    {
        $data = ['img12.png', 'img2.png', 'img1.png'];
        $dataCopy = $data;

        rsort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the rsort() method correctly performs
     * case-insensitive natural order sorting in descending order,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод rsort() корректно выполняет
     * регистронезависимую естественную сортировку в порядке убывания,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['File10.txt', 'file2.txt', 'FILE1.txt'];
        $dataCopy = $data;

        rsort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with empty array.
     *
     * This test verifies that the rsort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() с пустым массивом.
     *
     * Этот тест проверяет, что метод rsort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with single element.
     *
     * This test verifies that the rsort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() с одним элементом.
     *
     * Этот тест проверяет, что метод rsort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method resetting keys.
     *
     * This test verifies that the rsort() method resets numeric keys
     * after sorting, starting from 0,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() со сбросом ключей.
     *
     * Этот тест проверяет, что метод rsort() сбрасывает числовые ключи
     * после сортировки, начиная с 0,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortResettingKeys(): void
    {
        $data = ['a' => 100, 'b' => 50, 'c' => 75];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check sorted array with reset keys
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey(0, $cover->getDataAsArray());
        $this->assertArrayHasKey(1, $cover->getDataAsArray());
        $this->assertArrayHasKey(2, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with duplicate values.
     *
     * This test verifies that the rsort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод rsort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithDuplicateValues(): void
    {
        $data = [2, 3, 2, 1];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with mixed numeric and string values.
     *
     * This test verifies that the rsort() method correctly sorts
     * arrays containing mixed types,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() со смешанными числовыми и строковыми значениями.
     *
     * Этот тест проверяет, что метод rsort() корректно сортирует
     * массивы, содержащие смешанные типы,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithMixedTypes(): void
    {
        $data = [10, 'apple', 5, 'banana'];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the rsort() method with negative numbers.
     *
     * This test verifies that the rsort() method correctly sorts
     * arrays containing negative numbers in descending order,
     * mirroring PHP's rsort() function behavior.
     *
     *
     * Тестирование метода rsort() с отрицательными числами.
     *
     * Этот тест проверяет, что метод rsort() корректно сортирует
     * массивы, содержащие отрицательные числа, в порядке убывания,
     * отражая поведение функции rsort() PHP.
     *
     * @see CoverArray::rsort()
     * @see rsort()
     */
    public function testRsortWithNegativeNumbers(): void
    {
        $data = [-5, 10, -15, 0];
        $dataCopy = $data;

        rsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->rsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
