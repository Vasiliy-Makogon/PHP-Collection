<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UintersectUassocTest extends TestCase
{
    /**
     * Tests the uintersectUassoc() method with simple arrays.
     *
     * This test verifies that the uintersectUassoc() method correctly computes
     * the intersection of arrays using callbacks for both value and key comparison,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с простыми массивами.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно вычисляет
     * пересечение массивов, используя callback для сравнения и значений, и ключей,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithSimpleArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apple', 'b' => 'blueberry', 'd' => 'date'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with matching keys and values.
     *
     * This test verifies that the uintersectUassoc() method correctly finds
     * elements where both keys and values match according to their respective callbacks,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с совпадающими ключами и значениями.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно находит
     * элементы, где и ключи, и значения совпадают согласно их соответствующим callback,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithMatchingKeysAndValues(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect = ['a' => 1, 'c' => 3, 'd' => 4];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with case-insensitive key comparison.
     *
     * This test verifies that the uintersectUassoc() method correctly uses
     * a custom callback for case-insensitive key comparison,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с регистронезависимым сравнением ключей.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения ключей,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithCaseInsensitiveKeyComparison(): void
    {
        $data = ['A' => 'apple', 'B' => 'banana', 'C' => 'cherry'];
        $intersect = ['a' => 'apple', 'c' => 'cherry', 'd' => 'date'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with case-insensitive value comparison.
     *
     * This test verifies that the uintersectUassoc() method correctly uses
     * a custom callback for case-insensitive value comparison,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с регистронезависимым сравнением значений.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения значений,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithCaseInsensitiveValueComparison(): void
    {
        $data = ['a' => 'Apple', 'b' => 'Banana', 'c' => 'Cherry'];
        $intersect = ['a' => 'apple', 'c' => 'CHERRY'];

        $valueCallback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with different keys but same values.
     *
     * This test verifies that the uintersectUassoc() method excludes elements
     * where values match but keys differ, since both must match,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с разными ключами, но одинаковыми значениями.
     *
     * Этот тест проверяет, что метод uintersectUassoc() исключает элементы,
     * где значения совпадают, но ключи отличаются, так как оба должны совпадать,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithDifferentKeysButSameValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['x' => 'apple', 'y' => 'cherry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with same keys but different values.
     *
     * This test verifies that the uintersectUassoc() method excludes elements
     * where keys match but values differ, since both must match,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с одинаковыми ключами, но разными значениями.
     *
     * Этот тест проверяет, что метод uintersectUassoc() исключает элементы,
     * где ключи совпадают, но значения отличаются, так как оба должны совпадать,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithSameKeysButDifferentValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apricot', 'b' => 'blueberry'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with multiple comparison arrays.
     *
     * This test verifies that the uintersectUassoc() method correctly handles
     * multiple comparison arrays with custom callbacks,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно обрабатывает
     * несколько массивов сравнения с пользовательскими callback,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithMultipleComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['a' => 1, 'b' => 2, 'e' => 5];
        $intersect2 = ['a' => 1, 'c' => 3];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect1, $intersect2, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc(
                $valueCallback,
                $keyCallback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with empty result.
     *
     * This test verifies that the uintersectUassoc() method returns an empty array
     * when no key-value pairs are found in all comparison arrays,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с пустым результатом.
     *
     * Этот тест проверяет, что метод uintersectUassoc() возвращает пустой массив,
     * когда ни одна пара ключ-значение не найдена во всех массивах сравнения,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithEmptyResult(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $intersect = ['c' => 3, 'd' => 4];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with empty source array.
     *
     * This test verifies that the uintersectUassoc() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод uintersectUassoc() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithEmptySourceArray(): void
    {
        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with empty comparison arrays.
     *
     * This test verifies that the uintersectUassoc() method returns an empty array
     * when all comparison arrays are empty,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersectUassoc() возвращает пустой массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithEmptyComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = [];
        $intersect2 = [];

        $valueCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $keyCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_uassoc($data, $intersect1, $intersect2, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc(
                $valueCallback,
                $keyCallback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectUassoc() method with numeric keys.
     *
     * This test verifies that the uintersectUassoc() method correctly handles
     * numeric keys using custom callbacks for both key and value comparison,
     * mirroring PHP's array_uintersect_uassoc() function behavior.
     *
     *
     * Тестирование метода uintersectUassoc() с числовыми ключами.
     *
     * Этот тест проверяет, что метод uintersectUassoc() корректно обрабатывает
     * числовые ключи, используя пользовательские callback для сравнения и ключей, и значений,
     * отражая поведение функции array_uintersect_uassoc() PHP.
     *
     * @see CoverArray::uintersectUassoc()
     * @see array_uintersect_uassoc()
     */
    public function testUintersectUassocWithNumericKeys(): void
    {
        $data = [0 => 'a', 1 => 'b', 2 => 'c'];
        $intersect = [0 => 'a', 2 => 'c'];

        $valueCallback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $keyCallback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_uassoc($data, $intersect, $valueCallback, $keyCallback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectUassoc($valueCallback, $keyCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }
}
