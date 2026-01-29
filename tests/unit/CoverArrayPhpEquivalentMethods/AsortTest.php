<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AsortTest extends TestCase
{
    /**
     * Tests the asort() method with default sorting flags.
     *
     * This test verifies that the asort() method correctly sorts an array
     * in ascending order while maintaining key-value associations,
     * mirroring PHP's asort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода asort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод asort() корректно сортирует массив
     * в порядке возрастания, сохраняя ассоциацию ключ-значение,
     * отражая поведение функции asort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithDefaultFlags(): void
    {
        $data = ['a' => 3, 'b' => 1, 'c' => 2];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the asort() method correctly sorts an array
     * numerically in ascending order,
     * mirroring PHP's asort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода asort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод asort() корректно сортирует массив
     * численно в порядке возрастания,
     * отражая поведение функции asort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithSortNumeric(): void
    {
        $data = ['a' => '10', 'b' => '2', 'c' => '30'];
        $dataCopy = $data;

        asort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with SORT_STRING flag.
     *
     * This test verifies that the asort() method correctly sorts an array
     * as strings in ascending order,
     * mirroring PHP's asort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода asort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод asort() корректно сортирует массив
     * как строки в порядке возрастания,
     * отражая поведение функции asort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithSortString(): void
    {
        $data = ['a' => 'cherry', 'b' => 'apple', 'c' => 'banana'];
        $dataCopy = $data;

        asort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with SORT_NATURAL flag.
     *
     * This test verifies that the asort() method correctly performs
     * natural order sorting in ascending order,
     * mirroring PHP's asort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода asort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод asort() корректно выполняет
     * естественную сортировку в порядке возрастания,
     * отражая поведение функции asort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithSortNatural(): void
    {
        $data = ['a' => 'img12.png', 'b' => 'img2.png', 'c' => 'img1.png'];
        $dataCopy = $data;

        asort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the asort() method correctly performs
     * case-insensitive natural order sorting in ascending order,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод asort() корректно выполняет
     * регистронезависимую естественную сортировку в порядке возрастания,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['a' => 'File10.txt', 'b' => 'file2.txt', 'c' => 'FILE1.txt'];
        $dataCopy = $data;

        asort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with empty array.
     *
     * This test verifies that the asort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с пустым массивом.
     *
     * Этот тест проверяет, что метод asort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with single element.
     *
     * This test verifies that the asort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с одним элементом.
     *
     * Этот тест проверяет, что метод asort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithSingleElement(): void
    {
        $data = ['a' => 42];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method preserving keys.
     *
     * This test verifies that the asort() method maintains
     * the association between keys and values after sorting,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с сохранением ключей.
     *
     * Этот тест проверяет, что метод asort() сохраняет
     * ассоциацию между ключами и значениями после сортировки,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortPreservingKeys(): void
    {
        $data = ['first' => 100, 'second' => 50, 'third' => 75];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check sorted array and key preservation
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('first', $cover->getDataAsArray());
        $this->assertArrayHasKey('second', $cover->getDataAsArray());
        $this->assertArrayHasKey('third', $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with duplicate values.
     *
     * This test verifies that the asort() method correctly handles
     * arrays with duplicate values,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод asort() корректно обрабатывает
     * массивы с дублирующимися значениями,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithDuplicateValues(): void
    {
        $data = ['a' => 2, 'b' => 3, 'c' => 2, 'd' => 1];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with mixed numeric and string values.
     *
     * This test verifies that the asort() method correctly sorts
     * arrays containing mixed types,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() со смешанными числовыми и строковыми значениями.
     *
     * Этот тест проверяет, что метод asort() корректно сортирует
     * массивы, содержащие смешанные типы,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithMixedTypes(): void
    {
        $data = ['a' => 10, 'b' => 'apple', 'c' => 5, 'd' => 'banana'];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the asort() method with negative numbers.
     *
     * This test verifies that the asort() method correctly sorts
     * arrays containing negative numbers in ascending order,
     * mirroring PHP's asort() function behavior.
     *
     *
     * Тестирование метода asort() с отрицательными числами.
     *
     * Этот тест проверяет, что метод asort() корректно сортирует
     * массивы, содержащие отрицательные числа, в порядке возрастания,
     * отражая поведение функции asort() PHP.
     *
     * @see CoverArray::asort()
     * @see asort()
     */
    public function testAsortWithNegativeNumbers(): void
    {
        $data = ['a' => -5, 'b' => 10, 'c' => -15, 'd' => 0];
        $dataCopy = $data;

        asort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->asort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
