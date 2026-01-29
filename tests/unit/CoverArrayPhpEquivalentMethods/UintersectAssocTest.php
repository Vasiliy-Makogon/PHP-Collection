<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UintersectAssocTest extends TestCase
{
    /**
     * Tests the uintersectAssoc() method with simple arrays.
     *
     * This test verifies that the uintersectAssoc() method correctly computes
     * the intersection of arrays with additional index check, using a callback
     * for value comparison, mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с простыми массивами.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно вычисляет
     * пересечение массивов с дополнительной проверкой индексов, используя callback
     * для сравнения значений, отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithSimpleArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apple', 'b' => 'blueberry', 'd' => 'date'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with matching keys and values.
     *
     * This test verifies that the uintersectAssoc() method correctly finds
     * elements where both keys and values match according to comparison rules,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с совпадающими ключами и значениями.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно находит
     * элементы, где и ключи, и значения совпадают согласно правилам сравнения,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithMatchingKeysAndValues(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect = ['a' => 1, 'c' => 3, 'd' => 4];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with different keys but same values.
     *
     * This test verifies that the uintersectAssoc() method excludes elements
     * where values match but keys differ, since both must match,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с разными ключами, но одинаковыми значениями.
     *
     * Этот тест проверяет, что метод uintersectAssoc() исключает элементы,
     * где значения совпадают, но ключи отличаются, так как оба должны совпадать,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithDifferentKeysButSameValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['x' => 'apple', 'y' => 'banana'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with same keys but different values.
     *
     * This test verifies that the uintersectAssoc() method excludes elements
     * where keys match but values differ according to the callback,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с одинаковыми ключами, но разными значениями.
     *
     * Этот тест проверяет, что метод uintersectAssoc() исключает элементы,
     * где ключи совпадают, но значения отличаются согласно callback,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithSameKeysButDifferentValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apricot', 'b' => 'blueberry'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with case-insensitive value comparison.
     *
     * This test verifies that the uintersectAssoc() method correctly uses
     * a custom callback for case-insensitive value comparison,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с регистронезависимым сравнением значений.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения значений,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithCaseInsensitiveValueComparison(): void
    {
        $data = ['a' => 'Apple', 'b' => 'Banana', 'c' => 'Cherry'];
        $intersect = ['a' => 'apple', 'c' => 'CHERRY'];

        $callback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with multiple comparison arrays.
     *
     * This test verifies that the uintersectAssoc() method correctly handles
     * multiple comparison arrays, finding key-value pairs present in all of them,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно обрабатывает
     * несколько массивов сравнения, находя пары ключ-значение, присутствующие во всех них,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithMultipleComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['a' => 1, 'b' => 2, 'e' => 5];
        $intersect2 = ['a' => 1, 'c' => 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_assoc($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with empty result.
     *
     * This test verifies that the uintersectAssoc() method returns an empty array
     * when no key-value pairs are found in all comparison arrays,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с пустым результатом.
     *
     * Этот тест проверяет, что метод uintersectAssoc() возвращает пустой массив,
     * когда ни одна пара ключ-значение не найдена во всех массивах сравнения,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithEmptyResult(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $intersect = ['c' => 3, 'd' => 4];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with empty source array.
     *
     * This test verifies that the uintersectAssoc() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод uintersectAssoc() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithEmptySourceArray(): void
    {
        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with empty comparison arrays.
     *
     * This test verifies that the uintersectAssoc() method returns an empty array
     * when all comparison arrays are empty,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersectAssoc() возвращает пустой массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithEmptyComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = [];
        $intersect2 = [];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect_assoc($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with numeric indexed arrays.
     *
     * This test verifies that the uintersectAssoc() method correctly handles
     * numeric indexed arrays, comparing both indices and values,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() с числовыми индексированными массивами.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно обрабатывает
     * числовые индексированные массивы, сравнивая и индексы, и значения,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithNumericIndexedArrays(): void
    {
        $data = [0 => 'a', 1 => 'b', 2 => 'c'];
        $intersect = [0 => 'a', 2 => 'c'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersectAssoc() method with object value comparison.
     *
     * This test verifies that the uintersectAssoc() method correctly uses
     * a custom callback to compare object values by their properties,
     * while also checking key equality,
     * mirroring PHP's array_uintersect_assoc() function behavior.
     *
     *
     * Тестирование метода uintersectAssoc() со сравнением значений-объектов.
     *
     * Этот тест проверяет, что метод uintersectAssoc() корректно использует
     * пользовательский callback для сравнения значений-объектов по их свойствам,
     * также проверяя равенство ключей,
     * отражая поведение функции array_uintersect_assoc() PHP.
     *
     * @see CoverArray::uintersectAssoc()
     * @see array_uintersect_assoc()
     */
    public function testUintersectAssocWithObjectComparison(): void
    {
        $obj1 = (object)['id' => 1, 'name' => 'A'];
        $obj2 = (object)['id' => 2, 'name' => 'B'];
        $obj3 = (object)['id' => 1, 'name' => 'A'];

        $data = ['a' => $obj1, 'b' => $obj2];
        $intersect = ['a' => $obj3, 'c' => $obj2];

        $callback = function ($a, $b) {
            return $a->id <=> $b->id;
        };

        $expected = array_uintersect_assoc($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersectAssoc($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }
}
