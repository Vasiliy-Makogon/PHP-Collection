<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KrsortTest extends TestCase
{
    /**
     * Tests the krsort() method with default sorting flags.
     *
     * This test verifies that the krsort() method correctly sorts an array
     * by keys in descending order,
     * mirroring PHP's krsort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода krsort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод krsort() корректно сортирует массив
     * по ключам в порядке убывания,
     * отражая поведение функции krsort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithDefaultFlags(): void
    {
        $data = ['a' => 1, 'c' => 3, 'b' => 2];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the krsort() method correctly sorts an array
     * by numeric keys in descending order,
     * mirroring PHP's krsort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода krsort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод krsort() корректно сортирует массив
     * по числовым ключам в порядке убывания,
     * отражая поведение функции krsort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithSortNumeric(): void
    {
        $data = ['10' => 'ten', '2' => 'two', '30' => 'thirty'];
        $dataCopy = $data;

        krsort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with SORT_STRING flag.
     *
     * This test verifies that the krsort() method correctly sorts an array
     * by string keys in descending order,
     * mirroring PHP's krsort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода krsort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод krsort() корректно сортирует массив
     * по строковым ключам в порядке убывания,
     * отражая поведение функции krsort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithSortString(): void
    {
        $data = ['apple' => 1, 'cherry' => 3, 'banana' => 2];
        $dataCopy = $data;

        krsort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with SORT_NATURAL flag.
     *
     * This test verifies that the krsort() method correctly performs
     * natural order sorting by keys in descending order,
     * mirroring PHP's krsort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода krsort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод krsort() корректно выполняет
     * естественную сортировку по ключам в порядке убывания,
     * отражая поведение функции krsort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithSortNatural(): void
    {
        $data = ['img1.png' => 'a', 'img12.png' => 'b', 'img2.png' => 'c'];
        $dataCopy = $data;

        krsort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the krsort() method correctly performs
     * case-insensitive natural order sorting by keys in descending order,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод krsort() корректно выполняет
     * регистронезависимую естественную сортировку по ключам в порядке убывания,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['file1.txt' => 'a', 'FILE10.txt' => 'b', 'File2.txt' => 'c'];
        $dataCopy = $data;

        krsort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with empty array.
     *
     * This test verifies that the krsort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с пустым массивом.
     *
     * Этот тест проверяет, что метод krsort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with single element.
     *
     * This test verifies that the krsort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с одним элементом.
     *
     * Этот тест проверяет, что метод krsort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithSingleElement(): void
    {
        $data = ['key' => 42];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method sorting by keys.
     *
     * This test verifies that the krsort() method sorts
     * by keys in descending order while values remain associated,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с сортировкой по ключам.
     *
     * Этот тест проверяет, что метод krsort() сортирует
     * по ключам в порядке убывания, в то время как значения остаются связанными,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortSortingByKeys(): void
    {
        $data = ['first' => 50, 'third' => 100, 'second' => 75];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check sorted array and key-value associations
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame(100, $cover['third']);
        $this->assertSame(75, $cover['second']);
        $this->assertSame(50, $cover['first']);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with unique keys.
     *
     * This test verifies that the krsort() method maintains
     * unique key-value pairs after sorting,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с уникальными ключами.
     *
     * Этот тест проверяет, что метод krsort() сохраняет
     * уникальные пары ключ-значение после сортировки,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithUniqueKeys(): void
    {
        $data = ['z' => 1, 'a' => 2, 'm' => 3];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertCount(3, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with numeric keys.
     *
     * This test verifies that the krsort() method correctly sorts
     * arrays by numeric keys in descending order,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() с числовыми ключами.
     *
     * Этот тест проверяет, что метод krsort() корректно сортирует
     * массивы по числовым ключам в порядке убывания,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithNumericKeys(): void
    {
        $data = [1 => 'one', 10 => 'ten', 5 => 'five', 2 => 'two'];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the krsort() method with mixed key types.
     *
     * This test verifies that the krsort() method correctly sorts
     * arrays containing mixed string and numeric keys in descending order,
     * mirroring PHP's krsort() function behavior.
     *
     *
     * Тестирование метода krsort() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод krsort() корректно сортирует
     * массивы, содержащие смешанные строковые и числовые ключи, в порядке убывания,
     * отражая поведение функции krsort() PHP.
     *
     * @see CoverArray::krsort()
     * @see krsort()
     */
    public function testKrsortWithMixedKeyTypes(): void
    {
        $data = ['apple' => 'fruit', 10 => 'number', 'banana' => 'yellow', 5 => 'five'];
        $dataCopy = $data;

        krsort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->krsort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
