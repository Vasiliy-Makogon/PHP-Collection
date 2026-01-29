<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ArsortTest extends TestCase
{
    /**
     * Tests the arsort() method with default sorting flags.
     *
     * This test verifies that the arsort() method correctly sorts an array
     * in descending order while maintaining key-value associations,
     * mirroring PHP's arsort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода arsort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод arsort() корректно сортирует массив
     * в порядке убывания, сохраняя ассоциацию ключ-значение,
     * отражая поведение функции arsort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithDefaultFlags(): void
    {
        $data = ['a' => 3, 'b' => 1, 'c' => 2];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the arsort() method correctly sorts an array
     * numerically in descending order,
     * mirroring PHP's arsort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода arsort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод arsort() корректно сортирует массив
     * численно в порядке убывания,
     * отражая поведение функции arsort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithSortNumeric(): void
    {
        $data = ['a' => '10', 'b' => '2', 'c' => '30'];
        $dataCopy = $data;

        arsort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with SORT_STRING flag.
     *
     * This test verifies that the arsort() method correctly sorts an array
     * as strings in descending order,
     * mirroring PHP's arsort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода arsort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод arsort() корректно сортирует массив
     * как строки в порядке убывания,
     * отражая поведение функции arsort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithSortString(): void
    {
        $data = ['a' => 'cherry', 'b' => 'apple', 'c' => 'banana'];
        $dataCopy = $data;

        arsort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with SORT_NATURAL flag.
     *
     * This test verifies that the arsort() method correctly performs
     * natural order sorting in descending order,
     * mirroring PHP's arsort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода arsort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод arsort() корректно выполняет
     * естественную сортировку в порядке убывания,
     * отражая поведение функции arsort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithSortNatural(): void
    {
        $data = ['a' => 'img12.png', 'b' => 'img2.png', 'c' => 'img1.png'];
        $dataCopy = $data;

        arsort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the arsort() method correctly performs
     * case-insensitive natural order sorting in descending order,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод arsort() корректно выполняет
     * регистронезависимую естественную сортировку в порядке убывания,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['a' => 'File10.txt', 'b' => 'file2.txt', 'c' => 'FILE1.txt'];
        $dataCopy = $data;

        arsort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with empty array.
     *
     * This test verifies that the arsort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с пустым массивом.
     *
     * Этот тест проверяет, что метод arsort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with single element.
     *
     * This test verifies that the arsort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с одним элементом.
     *
     * Этот тест проверяет, что метод arsort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithSingleElement(): void
    {
        $data = ['a' => 42];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method preserving keys.
     *
     * This test verifies that the arsort() method maintains
     * the association between keys and values after sorting,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с сохранением ключей.
     *
     * Этот тест проверяет, что метод arsort() сохраняет
     * ассоциацию между ключами и значениями после сортировки,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortPreservingKeys(): void
    {
        $data = ['first' => 100, 'second' => 50, 'third' => 75];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check sorted array and key preservation
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('first', $cover->getDataAsArray());
        $this->assertArrayHasKey('second', $cover->getDataAsArray());
        $this->assertArrayHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with duplicate values.
     *
     * This test verifies that the arsort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод arsort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithDuplicateValues(): void
    {
        $data = ['a' => 2, 'b' => 3, 'c' => 2, 'd' => 1];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with mixed numeric and string values.
     *
     * This test verifies that the arsort() method correctly sorts
     * arrays containing mixed types,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() со смешанными числовыми и строковыми значениями.
     *
     * Этот тест проверяет, что метод arsort() корректно сортирует
     * массивы, содержащие смешанные типы,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithMixedTypes(): void
    {
        $data = ['a' => 10, 'b' => 'apple', 'c' => 5, 'd' => 'banana'];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the arsort() method with negative numbers.
     *
     * This test verifies that the arsort() method correctly sorts
     * arrays containing negative numbers in descending order,
     * mirroring PHP's arsort() function behavior.
     *
     *
     * Тестирование метода arsort() с отрицательными числами.
     *
     * Этот тест проверяет, что метод arsort() корректно сортирует
     * массивы, содержащие отрицательные числа, в порядке убывания,
     * отражая поведение функции arsort() PHP.
     *
     * @see CoverArray::arsort()
     * @see arsort()
     */
    public function testArsortWithNegativeNumbers(): void
    {
        $data = ['a' => -5, 'b' => 10, 'c' => -15, 'd' => 0];
        $dataCopy = $data;

        arsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->arsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
