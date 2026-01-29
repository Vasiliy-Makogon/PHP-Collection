<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UdiffAssocTest extends TestCase
{
    /**
     * Tests the udiffAssoc() method with simple arrays.
     *
     * This test verifies that the udiffAssoc() method correctly computes
     * the difference of arrays with additional index check, using a callback
     * for value comparison, mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с простыми массивами.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индексов, используя callback
     * для сравнения значений, отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithSimpleArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['a' => 'apple', 'b' => 'blueberry'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with matching keys but different values.
     *
     * This test verifies that the udiffAssoc() method correctly identifies
     * elements where keys match but values differ according to the callback,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с совпадающими ключами, но разными значениями.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно определяет
     * элементы, где ключи совпадают, но значения отличаются согласно callback,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithMatchingKeysButDifferentValues(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff = ['a' => 1, 'b' => 5, 'd' => 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with different keys but same values.
     *
     * This test verifies that the udiffAssoc() method keeps elements
     * where values match but keys differ, since both key and value must match
     * to be excluded, mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с разными ключами, но одинаковыми значениями.
     *
     * Этот тест проверяет, что метод udiffAssoc() сохраняет элементы,
     * где значения совпадают, но ключи отличаются, так как и ключ, и значение должны совпадать
     * для исключения, отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithDifferentKeysButSameValues(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff = ['x' => 'apple', 'y' => 'banana'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with case-insensitive value comparison.
     *
     * This test verifies that the udiffAssoc() method correctly uses
     * a custom callback for case-insensitive value comparison while
     * checking keys with default comparison,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с регистронезависимым сравнением значений.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно использует
     * пользовательский callback для регистронезависимого сравнения значений,
     * проверяя ключи стандартным сравнением,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithCaseInsensitiveComparison(): void
    {
        $data = ['a' => 'Apple', 'b' => 'Banana', 'c' => 'Cherry'];
        $diff = ['a' => 'apple', 'b' => 'BANANA'];

        $callback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with multiple comparison arrays.
     *
     * This test verifies that the udiffAssoc() method correctly handles
     * multiple comparison arrays, checking both keys and values,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно обрабатывает
     * несколько массивов сравнения, проверяя и ключи, и значения,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithMultipleComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['a' => 1, 'e' => 2];
        $diff2 = ['c' => 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff1, $diff2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with empty result.
     *
     * This test verifies that the udiffAssoc() method returns an empty array
     * when all key-value pairs are found in comparison arrays,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с пустым результатом.
     *
     * Этот тест проверяет, что метод udiffAssoc() возвращает пустой массив,
     * когда все пары ключ-значение найдены в массивах сравнения,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithEmptyResult(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $diff = ['a' => 1, 'b' => 2, 'c' => 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with no difference found.
     *
     * This test verifies that the udiffAssoc() method returns the entire array
     * when no key-value pairs match in comparison arrays,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() без найденных различий.
     *
     * Этот тест проверяет, что метод udiffAssoc() возвращает весь массив,
     * когда ни одна пара ключ-значение не совпадает в массивах сравнения,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithNoDifference(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff = ['x' => 4, 'y' => 5];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with empty source array.
     *
     * This test verifies that the udiffAssoc() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод udiffAssoc() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithEmptySourceArray(): void
    {
        $data = [];
        $diff = ['a' => 1, 'b' => 2];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with empty comparison arrays.
     *
     * This test verifies that the udiffAssoc() method returns the entire array
     * when all comparison arrays are empty,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод udiffAssoc() возвращает весь массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithEmptyComparisonArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff1 = [];
        $diff2 = [];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff_assoc($data, $diff1, $diff2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with numeric indexed arrays.
     *
     * This test verifies that the udiffAssoc() method correctly handles
     * numeric indexed arrays, comparing both indices and values,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() с числовыми индексированными массивами.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно обрабатывает
     * числовые индексированные массивы, сравнивая и индексы, и значения,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithNumericIndexedArrays(): void
    {
        $data = [0 => 'a', 1 => 'b', 2 => 'c'];
        $diff = [0 => 'a', 2 => 'c'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiffAssoc() method with object value comparison.
     *
     * This test verifies that the udiffAssoc() method correctly uses
     * a custom callback to compare object values by their properties,
     * while also checking key equality,
     * mirroring PHP's array_udiff_assoc() function behavior.
     *
     *
     * Тестирование метода udiffAssoc() со сравнением значений-объектов.
     *
     * Этот тест проверяет, что метод udiffAssoc() корректно использует
     * пользовательский callback для сравнения значений-объектов по их свойствам,
     * также проверяя равенство ключей,
     * отражая поведение функции array_udiff_assoc() PHP.
     *
     * @see CoverArray::udiffAssoc()
     * @see array_udiff_assoc()
     */
    public function testUdiffAssocWithObjectComparison(): void
    {
        $obj1 = (object)['id' => 1, 'name' => 'A'];
        $obj2 = (object)['id' => 2, 'name' => 'B'];
        $obj3 = (object)['id' => 1, 'name' => 'A'];

        $data = ['a' => $obj1, 'b' => $obj2];
        $diff = ['a' => $obj3];

        $callback = function ($a, $b) {
            return $a->id <=> $b->id;
        };

        $expected = array_udiff_assoc($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiffAssoc($callback, new CoverArray($diff))->getDataAsArray()
        );
    }
}
