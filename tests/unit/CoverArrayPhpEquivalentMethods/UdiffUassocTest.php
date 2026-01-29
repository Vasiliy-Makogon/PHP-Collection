<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UdiffUassocTest extends TestCase
{
    /**
     * Tests the udiffUassoc() method with simple arrays.
     *
     * This test verifies that the udiffUassoc() method correctly computes
     * the difference of arrays using callbacks for both value and key comparison,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с простыми массивами.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно вычисляет
     * расхождение массивов, используя callback для сравнения и значений, и ключей,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithSimpleArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['a' => 'apple', 'b' => 'blueberry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with matching keys and values.
     *
     * This test verifies that the udiffUassoc() method correctly excludes
     * elements where both keys and values match according to their respective callbacks,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с совпадающими ключами и значениями.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно исключает
     * элементы, где и ключи, и значения совпадают согласно их соответствующим callback,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithMatchingKeysAndValues(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff = ['a' => 1, 'c' => 3];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with case-insensitive key comparison.
     *
     * This test verifies that the udiffUassoc() method correctly uses
     * a custom callback for case-insensitive key comparison,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с регистронезависимым сравнением ключей.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения ключей,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithCaseInsensitiveKeyComparison(): void
    {
        $data = ['A' => 'apple', 'B' => 'banana', 'C' => 'cherry'];
        $diff = ['a' => 'apple', 'c' => 'cherry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with case-insensitive value comparison.
     *
     * This test verifies that the udiffUassoc() method correctly uses
     * a custom callback for case-insensitive value comparison,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с регистронезависимым сравнением значений.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения значений,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithCaseInsensitiveValueComparison(): void
    {
        $data = ['a' => 'Apple', 'b' => 'Banana', 'c' => 'Cherry'];
        $diff = ['a' => 'apple', 'c' => 'CHERRY'];

        $valueCallback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with different keys but same values.
     *
     * This test verifies that the udiffUassoc() method keeps elements
     * where values match but keys differ, since both must match to be excluded,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с разными ключами, но одинаковыми значениями.
     *
     * Этот тест проверяет, что метод udiffUassoc() сохраняет элементы,
     * где значения совпадают, но ключи отличаются, так как оба должны совпадать для исключения,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithDifferentKeysButSameValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['x' => 'apple', 'y' => 'cherry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with same keys but different values.
     *
     * This test verifies that the udiffUassoc() method keeps elements
     * where keys match but values differ, since both must match to be excluded,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с одинаковыми ключами, но разными значениями.
     *
     * Этот тест проверяет, что метод udiffUassoc() сохраняет элементы,
     * где ключи совпадают, но значения отличаются, так как оба должны совпадать для исключения,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithSameKeysButDifferentValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['a' => 'apricot', 'b' => 'blueberry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with multiple comparison arrays.
     *
     * This test verifies that the udiffUassoc() method correctly handles
     * multiple comparison arrays with custom callbacks,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно обрабатывает
     * несколько массивов сравнения с пользовательскими callback,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithMultipleComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['a' => 1, 'e' => 2];
        $diff2 = ['c' => 3];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff1, $diff2, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc(
                $valueCallback,
                $keyCallback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with empty result.
     *
     * This test verifies that the udiffUassoc() method returns an empty array
     * when all key-value pairs are found in comparison arrays,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с пустым результатом.
     *
     * Этот тест проверяет, что метод udiffUassoc() возвращает пустой массив,
     * когда все пары ключ-значение найдены в массивах сравнения,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithEmptyResult(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $diff = ['a' => 1, 'b' => 2, 'c' => 3];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with empty source array.
     *
     * This test verifies that the udiffUassoc() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод udiffUassoc() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithEmptySourceArray(): void
    {
        $data = [];
        $diff = ['a' => 1, 'b' => 2];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with empty comparison arrays.
     *
     * This test verifies that the udiffUassoc() method returns the entire array
     * when all comparison arrays are empty,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод udiffUassoc() возвращает весь массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithEmptyComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff1 = [];
        $diff2 = [];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_uassoc($data, $diff1, $diff2, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc(
                $valueCallback,
                $keyCallback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiffUassoc() method with numeric keys.
     *
     * This test verifies that the udiffUassoc() method correctly handles
     * numeric keys using custom callbacks for both key and value comparison,
     * mirroring PHP's array_udiff_uassoc() function behavior.
     *
     *
     * Тестирование метода udiffUassoc() с числовыми ключами.
     *
     * Этот тест проверяет, что метод udiffUassoc() корректно обрабатывает
     * числовые ключи, используя пользовательские callback для сравнения и ключей, и значений,
     * отражая поведение функции array_udiff_uassoc() PHP.
     *
     * @see CoverArray::udiffUassoc()
     * @see array_udiff_uassoc()
     */
    public function testUdiffUassocWithNumericKeys(): void
    {
        $data = [0 => 'a', 1 => 'b', 2 => 'c'];
        $diff = [0 => 'a', 2 => 'c'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_uassoc($data, $diff, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffUassoc($valueCallback, $keyCallback, new CoverArray($diff))->getDataAsArray()
        );
    }
}
