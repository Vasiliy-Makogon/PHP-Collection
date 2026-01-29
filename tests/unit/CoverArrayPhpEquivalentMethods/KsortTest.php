<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KsortTest extends TestCase
{
    /**
     * Tests the ksort() method with default sorting flags.
     *
     * This test verifies that the ksort() method correctly sorts an array
     * by keys in ascending order,
     * mirroring PHP's ksort() function behavior with SORT_REGULAR flag.
     *
     *
     * Тестирование метода ksort() с флагами сортировки по умолчанию.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует массив
     * по ключам в порядке возрастания,
     * отражая поведение функции ksort() PHP с флагом SORT_REGULAR.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithDefaultFlags(): void
    {
        $data = ['c' => 3, 'a' => 1, 'b' => 2];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with SORT_NUMERIC flag.
     *
     * This test verifies that the ksort() method correctly sorts an array
     * by numeric keys in ascending order,
     * mirroring PHP's ksort() function behavior with SORT_NUMERIC flag.
     *
     *
     * Тестирование метода ksort() с флагом SORT_NUMERIC.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует массив
     * по числовым ключам в порядке возрастания,
     * отражая поведение функции ksort() PHP с флагом SORT_NUMERIC.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithSortNumeric(): void
    {
        $data = ['10' => 'ten', '2' => 'two', '30' => 'thirty'];
        $dataCopy = $data;

        ksort($data, SORT_NUMERIC);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort(SORT_NUMERIC);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with SORT_STRING flag.
     *
     * This test verifies that the ksort() method correctly sorts an array
     * by keys as strings in ascending order,
     * mirroring PHP's ksort() function behavior with SORT_STRING flag.
     *
     *
     * Тестирование метода ksort() с флагом SORT_STRING.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует массив
     * по ключам как строкам в порядке возрастания,
     * отражая поведение функции ksort() PHP с флагом SORT_STRING.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithSortString(): void
    {
        $data = ['cherry' => 1, 'apple' => 2, 'banana' => 3];
        $dataCopy = $data;

        ksort($data, SORT_STRING);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort(SORT_STRING);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with SORT_NATURAL flag.
     *
     * This test verifies that the ksort() method correctly performs
     * natural order sorting by keys in ascending order,
     * mirroring PHP's ksort() function behavior with SORT_NATURAL flag.
     *
     *
     * Тестирование метода ksort() с флагом SORT_NATURAL.
     *
     * Этот тест проверяет, что метод ksort() корректно выполняет
     * естественную сортировку по ключам в порядке возрастания,
     * отражая поведение функции ksort() PHP с флагом SORT_NATURAL.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithSortNatural(): void
    {
        $data = ['img12' => 1, 'img2' => 2, 'img1' => 3];
        $dataCopy = $data;

        ksort($data, SORT_NATURAL);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort(SORT_NATURAL);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with SORT_NATURAL | SORT_FLAG_CASE flags.
     *
     * This test verifies that the ksort() method correctly performs
     * case-insensitive natural order sorting by keys in ascending order,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() с флагами SORT_NATURAL | SORT_FLAG_CASE.
     *
     * Этот тест проверяет, что метод ksort() корректно выполняет
     * регистронезависимую естественную сортировку по ключам в порядке возрастания,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithSortNaturalCaseInsensitive(): void
    {
        $data = ['File10' => 1, 'file2' => 2, 'FILE1' => 3];
        $dataCopy = $data;

        ksort($data, SORT_NATURAL | SORT_FLAG_CASE);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort(SORT_NATURAL | SORT_FLAG_CASE);

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with empty array.
     *
     * This test verifies that the ksort() method correctly handles
     * empty arrays without errors,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() с пустым массивом.
     *
     * Этот тест проверяет, что метод ksort() корректно обрабатывает
     * пустые массивы без ошибок,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check array is still empty
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with single element.
     *
     * This test verifies that the ksort() method correctly handles
     * arrays with a single element,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() с одним элементом.
     *
     * Этот тест проверяет, что метод ksort() корректно обрабатывает
     * массивы с одним элементом,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithSingleElement(): void
    {
        $data = ['a' => 42];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method sorting by keys.
     *
     * This test verifies that the ksort() method correctly sorts
     * by keys while values remain associated with their original keys,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() с сортировкой по ключам.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует
     * по ключам, в то время как значения остаются связанными с исходными ключами,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortSortingByKeys(): void
    {
        $data = ['third' => 100, 'first' => 50, 'second' => 75];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check sorted array and key-value associations
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame(50, $cover['first']);
        $this->assertSame(75, $cover['second']);
        $this->assertSame(100, $cover['third']);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with duplicate keys (impossible scenario).
     *
     * This test verifies that the ksort() method correctly handles
     * arrays without duplicate keys (as keys must be unique),
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() без дублирующихся ключей.
     *
     * Этот тест проверяет, что метод ksort() корректно обрабатывает
     * массивы без дублирующихся ключей (так как ключи должны быть уникальными),
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithUniqueKeys(): void
    {
        $data = ['b' => 2, 'd' => 3, 'a' => 2, 'c' => 1];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with numeric keys.
     *
     * This test verifies that the ksort() method correctly sorts
     * arrays with numeric keys in ascending order,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() с числовыми ключами.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует
     * массивы с числовыми ключами в порядке возрастания,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithNumericKeys(): void
    {
        $data = [10 => 'ten', 2 => 'two', 5 => 'five', 1 => 'one'];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the ksort() method with mixed key types.
     *
     * This test verifies that the ksort() method correctly sorts
     * arrays containing mixed string and numeric keys,
     * mirroring PHP's ksort() function behavior.
     *
     *
     * Тестирование метода ksort() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод ksort() корректно сортирует
     * массивы, содержащие смешанные строковые и числовые ключи,
     * отражая поведение функции ksort() PHP.
     *
     * @see CoverArray::ksort()
     * @see ksort()
     */
    public function testKsortWithMixedKeyTypes(): void
    {
        $data = [10 => 'number', 'apple' => 'fruit', 5 => 'five', 'banana' => 'yellow'];
        $dataCopy = $data;

        ksort($data);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->ksort();

        // Check sorted array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
