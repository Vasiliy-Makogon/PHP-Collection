<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UintersectTest extends TestCase
{
    /**
     * Tests the uintersect() method with simple numeric arrays.
     *
     * This test verifies that the uintersect() method correctly computes
     * the intersection of arrays using a callback for value comparison,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с простыми числовыми массивами.
     *
     * Этот тест проверяет, что метод uintersect() корректно вычисляет
     * пересечение массивов, используя callback для сравнения значений,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithSimpleNumericArrays(): void
    {
        $data = [1, 2, 3, 4, 5];
        $intersect1 = [2, 3, 6];
        $intersect2 = [3, 4];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with string arrays.
     *
     * This test verifies that the uintersect() method correctly computes
     * the intersection of string arrays using a string comparison callback,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() со строковыми массивами.
     *
     * Этот тест проверяет, что метод uintersect() корректно вычисляет
     * пересечение строковых массивов, используя callback для сравнения строк,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithStringArrays(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date'];
        $intersect = ['banana', 'date', 'elderberry'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with case-insensitive comparison.
     *
     * This test verifies that the uintersect() method correctly uses
     * a custom callback for case-insensitive value comparison,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с регистронезависимым сравнением.
     *
     * Этот тест проверяет, что метод uintersect() корректно использует
     * пользовательский callback для регистронезависимого сравнения значений,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithCaseInsensitiveComparison(): void
    {
        $data = ['Apple', 'Banana', 'Cherry'];
        $intersect = ['apple', 'CHERRY', 'date'];

        $callback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with associative arrays.
     *
     * This test verifies that the uintersect() method correctly computes
     * the intersection of associative arrays, comparing values only and preserving keys,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод uintersect() корректно вычисляет
     * пересечение ассоциативных массивов, сравнивая только значения и сохраняя ключи,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithAssociativeArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $intersect = ['x' => 'banana', 'y' => 'cherry', 'z' => 'date'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with empty result.
     *
     * This test verifies that the uintersect() method returns an empty array
     * when no values are found in all comparison arrays,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с пустым результатом.
     *
     * Этот тест проверяет, что метод uintersect() возвращает пустой массив,
     * когда ни одно значение не найдено во всех массивах сравнения,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithEmptyResult(): void
    {
        $data = [1, 2, 3];
        $intersect = [4, 5, 6];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with all values matching.
     *
     * This test verifies that the uintersect() method returns the entire array
     * when all values are found in comparison arrays,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() со всеми совпадающими значениями.
     *
     * Этот тест проверяет, что метод uintersect() возвращает весь массив,
     * когда все значения найдены в массивах сравнения,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithAllValuesMatching(): void
    {
        $data = [1, 2, 3];
        $intersect = [1, 2, 3, 4, 5];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with object comparison.
     *
     * This test verifies that the uintersect() method correctly uses
     * a custom callback to compare objects by their properties,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() со сравнением объектов.
     *
     * Этот тест проверяет, что метод uintersect() корректно использует
     * пользовательский callback для сравнения объектов по их свойствам,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithObjectComparison(): void
    {
        $obj1 = (object)['id' => 1, 'name' => 'A'];
        $obj2 = (object)['id' => 2, 'name' => 'B'];
        $obj3 = (object)['id' => 3, 'name' => 'C'];
        $obj4 = (object)['id' => 2, 'name' => 'B'];

        $data = [$obj1, $obj2, $obj3];
        $intersect = [$obj4];

        $callback = function ($a, $b) {
            return $a->id <=> $b->id;
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with multiple comparison arrays.
     *
     * This test verifies that the uintersect() method correctly handles
     * multiple comparison arrays, finding values present in all of them,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersect() корректно обрабатывает
     * несколько массивов сравнения, находя значения, присутствующие во всех них,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithMultipleComparisonArrays(): void
    {
        $data = [1, 2, 3, 4, 5];
        $intersect1 = [2, 3, 4, 6];
        $intersect2 = [3, 4, 5, 7];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with empty source array.
     *
     * This test verifies that the uintersect() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод uintersect() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithEmptySourceArray(): void
    {
        $data = [];
        $intersect = [1, 2, 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the uintersect() method with empty comparison arrays.
     *
     * This test verifies that the uintersect() method returns an empty array
     * when all comparison arrays are empty,
     * mirroring PHP's array_uintersect() function behavior.
     *
     *
     * Тестирование метода uintersect() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод uintersect() возвращает пустой массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_uintersect() PHP.
     *
     * @see CoverArray::uintersect()
     * @see array_uintersect()
     */
    public function testUintersectWithEmptyComparisonArrays(): void
    {
        $data = [1, 2, 3];
        $intersect1 = [];
        $intersect2 = [];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_uintersect($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->uintersect($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->uintersect(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }
}
